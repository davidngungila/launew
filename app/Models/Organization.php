<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{

    protected $fillable = [
        'name', 'code', 'email', 'phone', 'website', 'address', 'city', 'country', 'postal_code',
        'logo', 'settings', 'status', 'type', 'license_number', 'license_expiry', 'description',
        'social_media', 'timezone', 'currency', 'tax_id', 'registration_number', 'annual_revenue',
        'employee_count', 'founded_date'
    ];

    protected $casts = [
        'settings' => 'array',
        'social_media' => 'array',
        'license_expiry' => 'date',
        'founded_date' => 'date',
        'annual_revenue' => 'decimal:2',
        'employee_count' => 'integer',
    ];

    // Relationships
    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function activeUsers(): HasMany
    {
        return $this->hasMany(User::class)->where('is_active_employee', true);
    }

    public function mainBranch()
    {
        return $this->hasOne(Branch::class)->where('is_main_branch', true);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeTourOperators($query)
    {
        return $query->where('type', 'tour_operator');
    }

    // Methods
    public function getEmployeeCountAttribute(): int
    {
        return $this->activeUsers()->count();
    }

    public function getBranchCountAttribute(): int
    {
        return $this->branches()->where('status', 'active')->count();
    }

    public function getDepartmentCountAttribute(): int
    {
        return $this->departments()->where('status', 'active')->count();
    }

    public function getTotalRevenueAttribute(): float
    {
        return $this->branches()->sum('annual_revenue') + $this->annual_revenue;
    }

    public function getOperatingCountriesAttribute(): array
    {
        return $this->branches()->pluck('country')->unique()->filter()->values()->toArray();
    }

    public function getLogoUrlAttribute(): string
    {
        return $this->logo ? asset('storage/' . $this->logo) : asset('images/default-logo.png');
    }

    public function isLicenseValid(): bool
    {
        return !$this->license_expiry || $this->license_expiry->isFuture();
    }

    public function getLicenseStatusAttribute(): string
    {
        if (!$this->license_number) {
            return 'not_required';
        }

        if (!$this->license_expiry) {
            return 'valid';
        }

        if ($this->license_expiry->isPast()) {
            return 'expired';
        }

        if ($this->license_expiry->diffInDays(now()) <= 30) {
            return 'expiring_soon';
        }

        return 'valid';
    }

    public function getSettingsAttribute($value): array
    {
        $defaults = [
            'working_hours' => [
                'monday' => ['09:00', '17:00'],
                'tuesday' => ['09:00', '17:00'],
                'wednesday' => ['09:00', '17:00'],
                'thursday' => ['09:00', '17:00'],
                'friday' => ['09:00', '17:00'],
                'saturday' => ['closed'],
                'sunday' => ['closed'],
            ],
            'vacation_policy' => [
                'days_per_year' => 20,
                'accrual_rate' => 'monthly',
                'carry_over_limit' => 5,
            ],
            'expense_policy' => [
                'daily_limit' => 100,
                'monthly_limit' => 2000,
                'requires_approval' => true,
                'approval_threshold' => 500,
            ],
            'notification_settings' => [
                'email_notifications' => true,
                'sms_notifications' => false,
                'push_notifications' => true,
            ],
        ];

        return array_merge($defaults, (array) $value);
    }

    public function canAddBranch(): bool
    {
        $maxBranches = $this->settings['max_branches'] ?? 10;
        return $this->branches()->count() < $maxBranches;
    }

    public function canAddDepartment(): bool
    {
        $maxDepartments = $this->settings['max_departments'] ?? 20;
        return $this->departments()->count() < $maxDepartments;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{

    protected $fillable = [
        'organization_id', 'name', 'code', 'email', 'phone', 'address', 'city', 'country', 'postal_code',
        'latitude', 'longitude', 'status', 'type', 'manager_name', 'manager_email', 'manager_phone',
        'operating_hours', 'facilities', 'employee_count', 'established_date', 'notes', 'is_main_branch'
    ];

    protected $casts = [
        'operating_hours' => 'array',
        'facilities' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'established_date' => 'date',
        'employee_count' => 'integer',
        'is_main_branch' => 'boolean',
    ];

    // Relationships
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
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

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
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

    public function scopeInCountry($query, $country)
    {
        return $query->where('country', $country);
    }

    public function scopeMainBranch($query)
    {
        return $query->where('is_main_branch', true);
    }

    // Methods
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->country,
            $this->postal_code
        ]);

        return implode(', ', $parts);
    }

    public function getEmployeeCountAttribute(): int
    {
        return $this->activeUsers()->count();
    }

    public function getDepartmentCountAttribute(): int
    {
        return $this->departments()->where('status', 'active')->count();
    }

    public function getCoordinatesAttribute(): array
    {
        return [
            'lat' => $this->latitude,
            'lng' => $this->longitude
        ];
    }

    public function hasCoordinates(): bool
    {
        return $this->latitude && $this->longitude;
    }

    public function getOperatingHoursAttribute($value): array
    {
        $defaults = [
            'monday' => ['09:00', '17:00'],
            'tuesday' => ['09:00', '17:00'],
            'wednesday' => ['09:00', '17:00'],
            'thursday' => ['09:00', '17:00'],
            'friday' => ['09:00', '17:00'],
            'saturday' => ['09:00', '13:00'],
            'sunday' => ['closed'],
        ];

        return array_merge($defaults, (array) $value);
    }

    public function isOpenNow(): bool
    {
        $now = now()->setTimezone($this->organization->timezone ?? 'UTC');
        $day = strtolower($now->format('l'));
        $currentTime = $now->format('H:i');

        $hours = $this->operating_hours[$day] ?? ['closed'];

        if ($hours === ['closed']) {
            return false;
        }

        return $currentTime >= $hours[0] && $currentTime <= $hours[1];
    }

    public function getOperatingStatusAttribute(): string
    {
        if ($this->isOpenNow()) {
            return 'open';
        }

        return 'closed';
    }

    public function getFacilitiesListAttribute(): array
    {
        return $this->facilities ?? [];
    }

    public function hasFacility(string $facility): bool
    {
        return in_array($facility, $this->facilities_list);
    }

    public function getManagerAttribute()
    {
        if ($this->manager_email) {
            return User::where('email', $this->manager_email)->first();
        }

        return null;
    }

    public function getPerformanceMetrics(): array
    {
        return [
            'employee_count' => $this->employee_count,
            'department_count' => $this->department_count,
            'active_projects' => $this->activeProjects()->count(),
            'revenue_this_month' => $this->revenueThisMonth(),
            'customer_satisfaction' => $this->customerSatisfactionScore(),
        ];
    }

    public function activeProjects()
    {
        // Placeholder for project relationship
        return collect([]);
    }

    public function revenueThisMonth(): float
    {
        // Placeholder for revenue calculation
        return 0.00;
    }

    public function customerSatisfactionScore(): float
    {
        // Placeholder for satisfaction score
        return 4.5;
    }

    public function canAddDepartment(): bool
    {
        $maxDepartments = $this->organization->settings['max_departments_per_branch'] ?? 10;
        return $this->departments()->count() < $maxDepartments;
    }

    public function getGoogleMapsUrlAttribute(): string
    {
        if (!$this->hasCoordinates()) {
            return '';
        }

        return "https://maps.google.com/?q={$this->latitude},{$this->longitude}";
    }

    public function getDistanceFromAttribute($coordinates): float
    {
        if (!$this->hasCoordinates() || !is_array($coordinates) || !isset($coordinates['lat'], $coordinates['lng'])) {
            return 0;
        }

        $earthRadius = 6371; // Earth's radius in kilometers

        $latFrom = deg2rad($this->latitude);
        $lonFrom = deg2rad($this->longitude);
        $latTo = deg2rad($coordinates['lat']);
        $lonTo = deg2rad($coordinates['lng']);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos($latFrom) * cos($latTo) *
             sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}

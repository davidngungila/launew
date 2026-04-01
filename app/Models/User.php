<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'organization_id',
        'branch_id',
        'department_id',
        'employee_id',
        'job_title',
        'employment_type',
        'hire_date',
        'termination_date',
        'termination_reason',
        'salary',
        'work_phone',
        'work_email',
        'emergency_contacts',
        'skills',
        'certifications',
        'education',
        'work_experience',
        'performance_notes',
        'reporting_to_id',
        'is_active_employee',
        'work_location',
        'work_schedule',
        'last_performance_review',
        'next_performance_review',
        'desk_location',
        'access_permissions',
        'can_approve_expenses',
        'can_manage_team',
        'vacation_days_per_year',
        'sick_days_per_year',
        'used_vacation_days',
        'used_sick_days',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'hire_date' => 'date',
            'termination_date' => 'date',
            'last_performance_review' => 'date',
            'next_performance_review' => 'date',
            'salary' => 'decimal:2',
            'emergency_contacts' => 'array',
            'skills' => 'array',
            'certifications' => 'array',
            'education' => 'array',
            'work_experience' => 'array',
            'work_schedule' => 'array',
            'access_permissions' => 'array',
            'is_active_employee' => 'boolean',
            'can_approve_expenses' => 'boolean',
            'can_manage_team' => 'boolean',
            'vacation_days_per_year' => 'integer',
            'sick_days_per_year' => 'integer',
            'used_vacation_days' => 'integer',
            'used_sick_days' => 'integer',
        ];
    }

    // Organization Relationships
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function reportingTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporting_to_id');
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(User::class, 'reporting_to_id');
    }

    public function managedDepartments(): HasMany
    {
        return $this->hasMany(Department::class, 'manager_id');
    }

    public function assistedDepartments(): HasMany
    {
        return $this->hasMany(Department::class, 'assistant_manager_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasAnyRole(array $roles): bool
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active_employee', true);
    }

    public function scopeInOrganization($query, $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }

    public function scopeInBranch($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    public function scopeInDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    // Methods
    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->job_title ? "{$this->name} - {$this->job_title}" : $this->name;
    }

    public function getOrganizationNameAttribute(): string
    {
        return $this->organization ? $this->organization->name : 'No Organization';
    }

    public function getBranchNameAttribute(): string
    {
        return $this->branch ? $this->branch->name : 'No Branch';
    }

    public function getDepartmentNameAttribute(): string
    {
        return $this->department ? $this->department->name : 'No Department';
    }

    public function getEmployeeIdFormattedAttribute(): string
    {
        if (!$this->employee_id) {
            return 'N/A';
        }

        $orgCode = $this->organization ? $this->organization->code : 'EMP';
        return "{$orgCode}-{$this->employee_id}";
    }

    public function getEmploymentTypeLabelAttribute(): string
    {
        $labels = [
            'full_time' => 'Full Time',
            'part_time' => 'Part Time',
            'contract' => 'Contract',
            'intern' => 'Intern',
            'volunteer' => 'Volunteer',
        ];

        return $labels[$this->employment_type] ?? ucfirst(str_replace('_', ' ', $this->employment_type));
    }

    public function getYearsOfServiceAttribute(): int
    {
        if (!$this->hire_date) {
            return 0;
        }

        return $this->hire_date->diffInYears(now());
    }

    public function getRemainingVacationDaysAttribute(): int
    {
        return max(0, $this->vacation_days_per_year - $this->used_vacation_days);
    }

    public function getRemainingSickDaysAttribute(): int
    {
        return max(0, $this->sick_days_per_year - $this->used_sick_days);
    }

    public function getWorkEmailAttribute(): string
    {
        return $this->work_email ?? $this->email;
    }

    public function getWorkPhoneAttribute(): string
    {
        return $this->work_phone ?? $this->phone ?? '';
    }

    public function getSkillsListAttribute(): array
    {
        return $this->skills ?? [];
    }

    public function hasSkill(string $skill): bool
    {
        return in_array($skill, $this->skills_list);
    }

    public function getCertificationsListAttribute(): array
    {
        return $this->certifications ?? [];
    }

    public function hasCertification(string $certification): bool
    {
        return in_array($certification, $this->certifications_list);
    }

    public function getEducationListAttribute(): array
    {
        return $this->education ?? [];
    }

    public function getWorkExperienceListAttribute(): array
    {
        return $this->work_experience ?? [];
    }

    public function getEmergencyContactsListAttribute(): array
    {
        return $this->emergency_contacts ?? [];
    }

    public function isManager(): bool
    {
        return $this->managedDepartments()->count() > 0 || $this->can_manage_team;
    }

    public function isDepartmentHead(): bool
    {
        return $this->department && $this->department->manager_id === $this->id;
    }

    public function isBranchManager(): bool
    {
        return $this->branch && $this->branch->manager_email === $this->email;
    }

    public function canApproveExpenses(): bool
    {
        return $this->can_approve_expenses || $this->isManager() || $this->isDepartmentHead();
    }

    public function getDirectSubordinatesCountAttribute(): int
    {
        return $this->subordinates()->active()->count();
    }

    public function getAllSubordinatesCountAttribute(): int
    {
        $count = $this->direct_subordinates_count;
        
        foreach ($this->subordinates()->active()->get() as $subordinate) {
            $count += $subordinate->all_subordinates_count;
        }
        
        return $count;
    }

    public function getReportingChainAttribute(): array
    {
        $chain = [];
        $current = $this->reporting_to;
        
        while ($current) {
            $chain[] = $current;
            $current = $current->reporting_to;
        }
        
        return $chain;
    }

    public function getPerformanceRatingAttribute(): string
    {
        // Placeholder for performance rating logic
        if (!$this->last_performance_review) {
            return 'Not Reviewed';
        }

        $daysSinceReview = $this->last_performance_review->diffInDays(now());
        
        if ($daysSinceReview > 365) {
            return 'Overdue';
        } elseif ($daysSinceReview > 300) {
            return 'Due Soon';
        } else {
            return 'Good';
        }
    }

    public function getAccessPermissionsListAttribute(): array
    {
        return $this->access_permissions ?? [];
    }

    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->access_permissions_list);
    }

    public function isOnLeave(): bool
    {
        // Placeholder for leave checking logic
        return false;
    }

    public function getWorkLocationDisplayAttribute(): string
    {
        if ($this->work_location) {
            return $this->work_location;
        }

        if ($this->branch) {
            return $this->branch->name;
        }

        if ($this->department) {
            return $this->department->name;
        }

        return 'Remote';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{

    protected $fillable = [
        'organization_id', 'branch_id', 'name', 'code', 'description', 'status', 'type',
        'email', 'phone', 'manager_id', 'assistant_manager_id', 'employee_count', 'budget',
        'cost_centers', 'responsibilities', 'skills_required', 'established_date', 'notes',
        'parent_department_id', 'sort_order', 'is_core_department'
    ];

    protected $casts = [
        'cost_centers' => 'array',
        'responsibilities' => 'array',
        'skills_required' => 'array',
        'established_date' => 'date',
        'budget' => 'decimal:2',
        'employee_count' => 'integer',
        'sort_order' => 'integer',
        'is_core_department' => 'boolean',
    ];

    // Relationships
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function assistantManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assistant_manager_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function activeUsers(): HasMany
    {
        return $this->hasMany(User::class)->where('is_active_employee', true);
    }

    public function childDepartments(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_department_id');
    }

    public function parentDepartment()
    {
        return $this->belongsTo(Department::class, 'parent_department_id');
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

    public function scopeCoreDepartments($query)
    {
        return $query->where('is_core_department', true);
    }

    public function scopeInBranch($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_department_id');
    }

    // Methods
    public function getEmployeeCountAttribute(): int
    {
        return $this->activeUsers()->count();
    }

    public function getTotalEmployeeCountAttribute(): int
    {
        $count = $this->employee_count;
        
        foreach ($this->childDepartments as $child) {
            $count += $child->total_employee_count;
        }
        
        return $count;
    }

    public function getBudgetUtilizationAttribute(): float
    {
        if (!$this->budget) {
            return 0;
        }

        $spent = $this->expensesThisMonth();
        return ($spent / $this->budget) * 100;
    }

    public function expensesThisMonth(): float
    {
        // Placeholder for expense calculation
        return 0.00;
    }

    public function getManagerNameAttribute(): string
    {
        return $this->manager ? $this->manager->name : $this->manager_name ?? 'Not Assigned';
    }

    public function getAssistantManagerNameAttribute(): string
    {
        return $this->assistantManager ? $this->assistantManager->name : 'Not Assigned';
    }

    public function getFullCodeAttribute(): string
    {
        $orgCode = $this->organization ? $this->organization->code : 'ORG';
        $branchCode = $this->branch ? $this->branch->code : 'BR';
        
        return "{$orgCode}-{$branchCode}-{$this->code}";
    }

    public function getHierarchyLevelAttribute(): int
    {
        $level = 0;
        $parent = $this->parentDepartment;
        
        while ($parent) {
            $level++;
            $parent = $parent->parentDepartment;
        }
        
        return $level;
    }

    public function getDepartmentPathAttribute(): array
    {
        $path = [];
        $current = $this;
        
        while ($current) {
            array_unshift($path, $current);
            $current = $current->parentDepartment;
        }
        
        return $path;
    }

    public function getDepartmentTreeAttribute(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'type' => $this->type,
            'employee_count' => $this->total_employee_count,
            'manager' => $this->manager_name,
            'children' => $this->childDepartments->map->department_tree->toArray(),
        ];
    }

    public function getSkillsListAttribute(): array
    {
        return $this->skills_required ?? [];
    }

    public function hasSkill(string $skill): bool
    {
        return in_array($skill, $this->skills_list);
    }

    public function getResponsibilitiesListAttribute(): array
    {
        return $this->responsibilities ?? [];
    }

    public function hasResponsibility(string $responsibility): bool
    {
        return in_array($responsibility, $this->responsibilities_list);
    }

    public function getPerformanceMetrics(): array
    {
        return [
            'employee_count' => $this->total_employee_count,
            'budget_utilization' => $this->budget_utilization,
            'employee_satisfaction' => $this->employeeSatisfactionScore(),
            'productivity_score' => $this->productivityScore(),
            'training_completion' => $this->trainingCompletionRate(),
        ];
    }

    public function employeeSatisfactionScore(): float
    {
        // Placeholder for satisfaction calculation
        return 4.2;
    }

    public function productivityScore(): float
    {
        // Placeholder for productivity calculation
        return 85.5;
    }

    public function trainingCompletionRate(): float
    {
        // Placeholder for training completion
        return 78.0;
    }

    public function canAddEmployee(): bool
    {
        $maxEmployees = $this->branch->organization->settings['max_employees_per_department'] ?? 50;
        return $this->employee_count < $maxEmployees;
    }

    public function canAddSubDepartment(): bool
    {
        $maxSubDepartments = $this->branch->organization->settings['max_sub_departments'] ?? 5;
        return $this->childDepartments()->count() < $maxSubDepartments;
    }

    public function getDepartmentTypeLabelAttribute(): string
    {
        $labels = [
            'executive' => 'Executive',
            'operations' => 'Operations',
            'finance' => 'Finance',
            'human_resources' => 'Human Resources',
            'marketing' => 'Marketing',
            'sales' => 'Sales',
            'customer_service' => 'Customer Service',
            'it' => 'Information Technology',
            'legal' => 'Legal',
            'procurement' => 'Procurement',
            'quality_assurance' => 'Quality Assurance',
            'research_development' => 'Research & Development',
            'administration' => 'Administration',
            'tour_operations' => 'Tour Operations',
            'guides' => 'Tour Guides',
            'transport' => 'Transport',
            'accommodation' => 'Accommodation',
            'food_beverage' => 'Food & Beverage',
            'security' => 'Security',
            'maintenance' => 'Maintenance',
        ];

        return $labels[$this->type] ?? ucfirst(str_replace('_', ' ', $this->type));
    }

    public function getStatusColorAttribute(): string
    {
        $colors = [
            'active' => 'green',
            'inactive' => 'yellow',
            'merged' => 'gray',
        ];

        return $colors[$this->status] ?? 'gray';
    }

    public function getContactEmailAttribute(): string
    {
        return $this->email ?? ($this->manager ? $this->manager->email : '');
    }

    public function getContactPhoneAttribute(): string
    {
        return $this->phone ?? ($this->manager ? $this->manager->phone : '');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('organization_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('employee_id')->unique()->nullable();
            $table->string('job_title')->nullable();
            $table->enum('employment_type', ['full_time', 'part_time', 'contract', 'intern', 'volunteer'])->default('full_time');
            $table->date('hire_date')->nullable();
            $table->date('termination_date')->nullable();
            $table->enum('termination_reason', ['resignation', 'termination', 'retirement', 'contract_end', 'other'])->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('work_phone')->nullable();
            $table->string('work_email')->nullable();
            $table->json('emergency_contacts')->nullable();
            $table->json('skills')->nullable();
            $table->json('certifications')->nullable();
            $table->json('education')->nullable();
            $table->json('work_experience')->nullable();
            $table->text('performance_notes')->nullable();
            $table->integer('reporting_to_id')->nullable();
            $table->boolean('is_active_employee')->default(true);
            $table->string('work_location')->nullable();
            $table->json('work_schedule')->nullable();
            $table->date('last_performance_review')->nullable();
            $table->date('next_performance_review')->nullable();
            $table->string('desk_location')->nullable();
            $table->json('access_permissions')->nullable();
            $table->boolean('can_approve_expenses')->default(false);
            $table->boolean('can_manage_team')->default(false);
            $table->integer('vacation_days_per_year')->default(20);
            $table->integer('sick_days_per_year')->default(10);
            $table->integer('used_vacation_days')->default(0);
            $table->integer('used_sick_days')->default(0);
            
            $table->index(['organization_id', 'is_active_employee']);
            $table->index(['branch_id', 'department_id']);
            $table->index('employee_id');
            $table->index('job_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['department_id']);
            $table->dropColumn([
                'organization_id', 'branch_id', 'department_id', 'employee_id', 'job_title',
                'employment_type', 'hire_date', 'termination_date', 'termination_reason', 'salary',
                'work_phone', 'work_email', 'emergency_contacts', 'skills', 'certifications',
                'education', 'work_experience', 'performance_notes', 'reporting_to_id',
                'is_active_employee', 'work_location', 'work_schedule', 'last_performance_review',
                'next_performance_review', 'desk_location', 'access_permissions',
                'can_approve_expenses', 'can_manage_team', 'vacation_days_per_year',
                'sick_days_per_year', 'used_vacation_days', 'used_sick_days'
            ]);
        });
    }
};

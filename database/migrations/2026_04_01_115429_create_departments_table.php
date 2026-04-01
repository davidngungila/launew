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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->foreignId('branch_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name', 255);
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive', 'merged'])->default('active');
            $table->enum('type', [
                'executive', 'operations', 'finance', 'human_resources', 'marketing', 
                'sales', 'customer_service', 'it', 'legal', 'procurement', 'quality_assurance',
                'research_development', 'administration', 'tour_operations', 'guides', 'transport',
                'accommodation', 'food_beverage', 'security', 'maintenance'
            ])->default('operations');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('manager_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('assistant_manager_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('employee_count')->default(0);
            $table->decimal('budget', 15, 2)->nullable();
            $table->json('cost_centers')->nullable();
            $table->json('responsibilities')->nullable();
            $table->json('skills_required')->nullable();
            $table->date('established_date')->nullable();
            $table->text('notes')->nullable();
            $table->integer('parent_department_id')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_core_department')->default(false);
            $table->timestamps();
            
            $table->index(['organization_id', 'status']);
            $table->index(['branch_id', 'status']);
            $table->index('code');
            $table->index(['type', 'status']);
            $table->index('manager_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};

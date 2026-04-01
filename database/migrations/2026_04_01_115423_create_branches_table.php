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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->string('name', 255);
            $table->string('code', 50)->unique();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('status', ['active', 'inactive', 'closed'])->default('active');
            $table->enum('type', ['headquarters', 'regional', 'local', 'virtual'])->default('local');
            $table->string('manager_name')->nullable();
            $table->string('manager_email')->nullable();
            $table->string('manager_phone')->nullable();
            $table->json('operating_hours')->nullable();
            $table->json('facilities')->nullable();
            $table->integer('employee_count')->default(0);
            $table->date('established_date')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_main_branch')->default(false);
            $table->timestamps();
            
            $table->index(['organization_id', 'status']);
            $table->index('code');
            $table->index(['type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};

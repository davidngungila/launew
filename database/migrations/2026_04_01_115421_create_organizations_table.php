<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('code', 50)->unique();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('logo')->nullable();
            $table->json('settings')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->enum('type', ['tour_operator', 'travel_agency', 'hospitality', 'corporate', 'government', 'ngo'])->default('tour_operator');
            $table->string('license_number')->nullable();
            $table->date('license_expiry')->nullable();
            $table->text('description')->nullable();
            $table->json('social_media')->nullable();
            $table->string('timezone')->default('UTC');
            $table->string('currency', 3)->default('USD');
            $table->string('tax_id')->nullable();
            $table->string('registration_number')->nullable();
            $table->decimal('annual_revenue', 15, 2)->nullable();
            $table->integer('employee_count')->default(0);
            $table->date('founded_date')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'type']);
            $table->index('code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};

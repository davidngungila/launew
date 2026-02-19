<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role'); // guide, driver, etc.
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->enum('status', ['active', 'inactive', 'on_tour'])->default('active');
            $table->timestamps();
        });

        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('plate_number')->unique();
            $table->integer('capacity');
            $table->string('photo')->nullable();
            $table->enum('status', ['active', 'maintenance', 'on_tour'])->default('active');
            $table->json('maintenance_logs')->nullable();
            $table->json('fuel_logs')->nullable();
            $table->timestamps();
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('guide_id')->nullable()->constrained('staff');
            $table->foreignId('driver_id')->nullable()->constrained('staff');
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('guide_id');
            $table->dropConstrainedForeignId('driver_id');
            $table->dropConstrainedForeignId('vehicle_id');
        });
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('staff');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Seed defaults
        DB::table('expense_categories')->insert([
            ['key' => 'fuel', 'name' => 'Fuel', 'is_active' => true, 'sort_order' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'accommodation', 'name' => 'Accommodation', 'is_active' => true, 'sort_order' => 20, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'park_fees', 'name' => 'Park fees', 'is_active' => true, 'sort_order' => 30, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'flight', 'name' => 'Flights', 'is_active' => true, 'sort_order' => 40, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'maintenance', 'name' => 'Maintenance', 'is_active' => true, 'sort_order' => 50, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'staff', 'name' => 'Staff', 'is_active' => true, 'sort_order' => 60, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'supplier_bill', 'name' => 'Supplier bill', 'is_active' => true, 'sort_order' => 70, 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'other', 'name' => 'Other', 'is_active' => true, 'sort_order' => 999, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('expense_categories');
    }
};

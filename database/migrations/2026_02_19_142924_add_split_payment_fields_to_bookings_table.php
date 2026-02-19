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
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('deposit_amount', 15, 2)->nullable()->after('total_price');
            $table->boolean('is_deposit_paid')->default(false)->after('deposit_amount');
            $table->decimal('balance_amount', 15, 2)->nullable()->after('is_deposit_paid');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['deposit_amount', 'is_deposit_paid', 'balance_amount']);
        });
    }
};

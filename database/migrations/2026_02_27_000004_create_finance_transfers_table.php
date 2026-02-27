<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finance_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_account_id')->constrained('finance_accounts');
            $table->foreignId('to_account_id')->constrained('finance_accounts');
            $table->decimal('amount', 15, 2);
            $table->date('transfer_date');
            $table->string('reference')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finance_transfers');
    }
};

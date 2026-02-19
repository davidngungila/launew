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
        Schema::create('notification_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sms_username')->nullable();
            $table->string('sms_password')->nullable();
            $table->string('sms_bearer_token')->nullable();
            $table->string('sms_from');
            $table->text('sms_url');
            $table->enum('sms_method', ['get', 'post'])->default('post');
            $table->integer('priority')->default(0);
            $table->text('notes')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_active')->default(true);
            $table->enum('connection_status', ['connected', 'disconnected', 'unknown'])->default('unknown');
            $table->timestamp('last_tested_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_providers');
    }
};

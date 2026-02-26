<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('otp_logins', function (Blueprint $table) {
            $table->string('verify_token', 64)->nullable()->after('otp_hash');
            $table->index('verify_token');
        });
    }

    public function down(): void
    {
        Schema::table('otp_logins', function (Blueprint $table) {
            $table->dropIndex(['verify_token']);
            $table->dropColumn('verify_token');
        });
    }
};

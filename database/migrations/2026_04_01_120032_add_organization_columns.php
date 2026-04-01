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
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('name', 255)->after('id');
            $table->string('code', 50)->unique()->after('name');
            $table->string('email')->nullable()->after('code');
            $table->string('phone')->nullable()->after('email');
            $table->string('website')->nullable()->after('phone');
            $table->text('address')->nullable()->after('website');
            $table->string('city')->nullable()->after('address');
            $table->string('country')->nullable()->after('city');
            $table->string('postal_code')->nullable()->after('country');
            $table->string('logo')->nullable()->after('postal_code');
            $table->json('settings')->nullable()->after('logo');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('settings');
            $table->enum('type', ['tour_operator', 'travel_agency', 'hospitality', 'corporate', 'government', 'ngo'])->default('tour_operator')->after('status');
            $table->string('license_number')->nullable()->after('type');
            $table->date('license_expiry')->nullable()->after('license_number');
            $table->text('description')->nullable()->after('license_expiry');
            $table->json('social_media')->nullable()->after('description');
            $table->string('timezone')->default('UTC')->after('social_media');
            $table->string('currency', 3)->default('USD')->after('timezone');
            $table->string('tax_id')->nullable()->after('currency');
            $table->string('registration_number')->nullable()->after('tax_id');
            $table->decimal('annual_revenue', 15, 2)->nullable()->after('registration_number');
            $table->integer('employee_count')->default(0)->after('annual_revenue');
            $table->date('founded_date')->nullable()->after('employee_count');
        });
    }

    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn([
                'name', 'code', 'email', 'phone', 'website', 'address', 'city', 'country', 'postal_code',
                'logo', 'settings', 'status', 'type', 'license_number', 'license_expiry', 'description',
                'social_media', 'timezone', 'currency', 'tax_id', 'registration_number', 'annual_revenue',
                'employee_count', 'founded_date'
            ]);
        });
    }
};

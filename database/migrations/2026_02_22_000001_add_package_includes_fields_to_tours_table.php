<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->json('package_destinations')->nullable()->after('location');
            $table->json('target_markets')->nullable()->after('package_destinations');
            $table->decimal('international_price_min', 10, 2)->nullable()->after('base_price');
            $table->decimal('international_price_max', 10, 2)->nullable()->after('international_price_min');
            $table->string('best_season')->nullable()->after('international_price_max');
            $table->json('interactive_features')->nullable()->after('best_season');
            $table->json('addons')->nullable()->after('interactive_features');
            $table->json('conversion_triggers')->nullable()->after('addons');
        });
    }

    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn([
                'package_destinations',
                'target_markets',
                'international_price_min',
                'international_price_max',
                'best_season',
                'interactive_features',
                'addons',
                'conversion_triggers',
            ]);
        });
    }
};

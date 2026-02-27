<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_sessions', function (Blueprint $table) {
            $table->id();
            $table->uuid('session_uuid')->unique();
            $table->string('visitor_id', 64)->index();

            $table->string('ip', 64)->nullable();
            $table->string('country', 2)->nullable()->index();
            $table->string('city')->nullable()->index();

            $table->string('device_type', 20)->nullable()->index();
            $table->string('browser', 50)->nullable()->index();
            $table->string('os', 50)->nullable()->index();

            $table->string('referrer_host')->nullable()->index();
            $table->string('utm_source')->nullable()->index();
            $table->string('utm_medium')->nullable()->index();
            $table->string('utm_campaign')->nullable()->index();

            $table->timestamp('started_at')->nullable()->index();
            $table->timestamp('last_seen_at')->nullable()->index();
            $table->unsignedInteger('pageviews_count')->default(0);
            $table->unsignedInteger('events_count')->default(0);
            $table->timestamp('ended_at')->nullable()->index();

            $table->timestamps();
        });

        Schema::create('analytics_pageviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('analytics_session_id')->constrained('analytics_sessions')->cascadeOnDelete();

            $table->string('path')->index();
            $table->string('full_url')->nullable();
            $table->string('title')->nullable();

            $table->string('referrer')->nullable();

            $table->unsignedInteger('screen_w')->nullable();
            $table->unsignedInteger('screen_h')->nullable();
            $table->string('language', 20)->nullable();
            $table->string('timezone', 60)->nullable();

            $table->timestamp('viewed_at')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_pageviews');
        Schema::dropIfExists('analytics_sessions');
    }
};

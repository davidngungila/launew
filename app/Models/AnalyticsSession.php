<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnalyticsSession extends Model
{
    protected $fillable = [
        'session_uuid',
        'visitor_id',
        'ip',
        'country',
        'city',
        'device_type',
        'browser',
        'os',
        'referrer_host',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'started_at',
        'last_seen_at',
        'pageviews_count',
        'events_count',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'last_seen_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function pageviews(): HasMany
    {
        return $this->hasMany(AnalyticsPageview::class, 'analytics_session_id');
    }
}

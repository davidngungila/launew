<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalyticsPageview extends Model
{
    protected $fillable = [
        'analytics_session_id',
        'path',
        'full_url',
        'title',
        'referrer',
        'screen_w',
        'screen_h',
        'language',
        'timezone',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(AnalyticsSession::class, 'analytics_session_id');
    }
}

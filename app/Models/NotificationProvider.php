<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationProvider extends Model
{
    protected $fillable = [
        'name', 'sms_username', 'sms_password', 'sms_bearer_token', 
        'sms_from', 'sms_url', 'sms_method', 'priority', 
        'notes', 'is_primary', 'is_active', 'connection_status', 
        'last_tested_at'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
        'last_tested_at' => 'datetime',
    ];

    public static function getPrimary(?string $type = null): ?self
    {
        return static::query()
            ->where('is_active', true)
            ->where('is_primary', true)
            ->orderBy('priority')
            ->first();
    }

    public function getStatusBadgeClass()
    {
        return match($this->connection_status) {
            'connected' => 'bg-label-success',
            'disconnected' => 'bg-label-danger',
            default => 'bg-label-secondary',
        };
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpLogin extends Model
{
    protected $fillable = [
        'user_id',
        'otp_hash',
        'expires_at',
        'attempts',
        'sent_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'sent_at' => 'datetime',
        'attempts' => 'integer',
    ];
}

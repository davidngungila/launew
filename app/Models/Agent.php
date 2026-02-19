<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'company_name', 'commission_rate'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

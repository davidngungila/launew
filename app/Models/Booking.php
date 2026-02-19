<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id', 'user_id', 'customer_name', 'customer_email', 'customer_phone',
        'start_date', 'adults', 'children', 'special_requests', 'total_price',
        'status', 'payment_status', 'payment_method', 'payment_reference',
        'guide_id', 'driver_id', 'vehicle_id', 'agent_id', 'agent_commission',
        'stripe_payment_intent_id', 'stripe_payment_status',
        'deposit_amount', 'is_deposit_paid', 'balance_amount'
    ];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function guide(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'guide_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'driver_id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }
}

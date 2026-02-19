<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'location', 'duration_days', 
        'base_price', 'images', 'inclusions', 'exclusions', 'featured', 'status'
    ];

    protected $casts = [
        'images' => 'array',
        'inclusions' => 'array',
        'exclusions' => 'array',
        'featured' => 'boolean',
    ];

    public function itineraries(): HasMany
    {
        return $this->hasMany(Itinerary::class)->orderBy('day_number');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}

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
        'base_price', 'international_price_min', 'international_price_max',
        'best_season',
        'images', 'inclusions', 'exclusions',
        'package_destinations', 'target_markets',
        'interactive_features', 'addons', 'conversion_triggers',
        'featured', 'status'
    ];

    protected $casts = [
        'images' => 'array',
        'inclusions' => 'array',
        'exclusions' => 'array',
        'package_destinations' => 'array',
        'target_markets' => 'array',
        'interactive_features' => 'array',
        'addons' => 'array',
        'conversion_triggers' => 'array',
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

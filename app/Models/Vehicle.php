<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'model', 'plate_number', 'capacity', 'photo', 'status', 'maintenance_logs', 'fuel_logs'
    ];

    protected $casts = [
        'maintenance_logs' => 'array',
        'fuel_logs' => 'array',
    ];
}

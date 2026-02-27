<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'category',
        'frequency',
        'starts_on',
        'next_run_on',
        'is_active',
    ];

    protected $casts = [
        'starts_on' => 'date',
        'next_run_on' => 'date',
        'is_active' => 'boolean',
        'amount' => 'decimal:2',
    ];
}

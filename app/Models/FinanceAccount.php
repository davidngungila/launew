<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinanceAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'currency',
        'institution',
        'account_number',
        'opening_balance',
        'current_balance',
        'is_active',
        'last_reconciled_at',
    ];

    protected $casts = [
        'opening_balance' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'is_active' => 'boolean',
        'last_reconciled_at' => 'datetime',
    ];

    public function outgoingTransfers(): HasMany
    {
        return $this->hasMany(FinanceTransfer::class, 'from_account_id');
    }

    public function incomingTransfers(): HasMany
    {
        return $this->hasMany(FinanceTransfer::class, 'to_account_id');
    }

    public function reconciliations(): HasMany
    {
        return $this->hasMany(FinanceReconciliation::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_transaction',
        'customer_name',
        'total_price',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detailTransactions(): HasMany
    {
        return $this->hasMany(DetailTransaction::class, 'id_transaction');
    }

    public function getTotalPriceWithCustomizationAttribute()
    {
        $total = $this->detailTransactions->sum(function ($detail) {
            return $detail->subtotal + $detail->menu->customizationOptions->sum('additional_price');
        });

        return $total * 1.1;
    }

    public function details()
    {
        return $this->hasMany(DetailTransaction::class, 'id_transaction');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DetailTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'menu_id',
        'quantity',
        'subtotal',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function detailTransactionCustomOptions(): HasMany
    {
        return $this->hasMany(DetailTransactionCustomOption::class);
    }

    protected function groupedCustomOptionsByItemIndex(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->detailTransactionCustomOptions->groupBy('item_index'),
        );
    }
}

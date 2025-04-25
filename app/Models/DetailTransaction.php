<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_transaction',
        'id_menu',
        'quantity',
        'subtotal',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }

    public function getSubtotalAttribute()
    {
        $menu = $this->menu;

        $customizationPrice = 0;
        if ($menu->is_customizable && $menu->customizationOptions) {
            $customizationPrice = $this->menu->customizationOptions->sum('additional_price');
        }

        return ($this->quantity * $menu->price) + $customizationPrice;
    }

    public function detailCustomOptions()
    {
        return $this->hasMany(DetailCustomOption::class, 'detail_transaction_id');
    }
}

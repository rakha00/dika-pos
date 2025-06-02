<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransactionCustomOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'detail_transaction_id',
        'custom_option_id'
    ];

    public function detailTransaction(): BelongsTo
    {
        return $this->belongsTo(DetailTransaction::class);
    }

    public function customOption(): BelongsTo
    {
        return $this->belongsTo(CustomOption::class);
    }
}

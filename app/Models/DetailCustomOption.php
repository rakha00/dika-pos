<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailCustomOption extends Model
{
    use HasFactory;

    protected $table = 'detail_custom_options';

    protected $fillable = [
        'detail_transaction_id',
        'custom_option_value_id'
    ];

    public function detailTransaction()
    {
        return $this->belongsTo(DetailTransaction::class, 'detail_transaction_id');
    }

    public function customOptionValue()
    {
        return $this->belongsTo(CustomOptionValue::class, 'custom_option_value_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailCustomOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'detail_transaction_id',
        'custom_option_id'
    ];
}

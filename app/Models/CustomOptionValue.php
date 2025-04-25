<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomOptionValue extends Model
{
    use HasFactory;

    protected $table = 'custom_option_values';

    protected $fillable = [
        'custom_option_id',
        'value',
        'additional_price',
    ];

    public function customOptionValues()
    {
        return $this->belongsTo(CustomOption::class, 'custom_option_id');
    }

    public function customOption()
    {
        return $this->belongsTo(CustomOption::class, 'custom_option_id');
    }
}

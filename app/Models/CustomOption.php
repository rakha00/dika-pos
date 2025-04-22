<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomOption extends Model
{
    use HasFactory;

    protected $table = 'custom_options';

    protected $fillable = [
        'name',
        'type', // misalnya: radio, dropdown, dll
    ];

    public function values()
    {
        return $this->hasMany(CustomOptionValue::class);
    }

    public function customOptionValues()
    {
        return $this->hasMany(CustomOptionValue::class, 'custom_option_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'category',
        'value',
        'type',
        'additional_price',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}

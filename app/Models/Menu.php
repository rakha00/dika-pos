<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'image',
        'price',
        'stock',
    ];

    public function customOptions()
    {
        return $this->hasMany(CustomOption::class);
    }

    public function detailTransactions()
    {
        return $this->hasMany(DetailTransaction::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function customOptions() : HasMany
    {
        return $this->hasMany(CustomOption::class);
    }

    public function detailTransactions() : HasMany
    {
        return $this->hasMany(DetailTransaction::class);
    }
}

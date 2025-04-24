<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'name',
        'price',
        'is_customizable'
    ];

    public function customOptions()
    {
        return $this->belongsToMany(CustomOption::class, 'menu_custom_option', 'id_menu', 'custom_option_id');
    }

    public function detailTransactions()
    {
        return $this->hasMany(DetailTransaction::class); // jika ada relasi transaksi
    }
}

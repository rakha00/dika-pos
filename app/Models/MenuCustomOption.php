<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuCustomOption extends Model
{
    use HasFactory;

    protected $table = 'menu_custom_option';

    protected $fillable = [
        'id_menu',
        'custom_option_id'
    ];
}

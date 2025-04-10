<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'total_harga',
        'waktu_transaksi',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detail_transaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}

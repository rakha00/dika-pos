<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
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

    public function detail_transactions()
    {
        return $this->hasMany(DetailTransaction::class, 'id_transaction');
    }
}

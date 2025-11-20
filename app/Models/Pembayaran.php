<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'pesanan_id',
        'metode',
        'jumlah',
        'status',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}

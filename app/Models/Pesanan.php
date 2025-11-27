<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'total_harga',
        'tgl_pesan',
        'alamat',
        'jenis_pembayaran',
        'jenis_pengiriman',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itemPesanans()
    {
        return $this->hasMany(ItemPesanan::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }
}

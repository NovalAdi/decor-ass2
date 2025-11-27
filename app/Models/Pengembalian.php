<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $fillable = [
        'pesanan_id',
        'tipe',
        'judul',
        'deskripsi',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}

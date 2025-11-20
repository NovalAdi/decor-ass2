<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarPengembalian extends Model
{
    protected $fillable = [
        'pengembalian_id',
        'gambar',
    ];

    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class);
    }
}

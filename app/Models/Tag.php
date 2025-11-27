<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
    ];

    public function produks()
    {
        return $this->belongsToMany(Produk::class, 'produk_tag', 'tag_id', 'produk_id');
    }
}

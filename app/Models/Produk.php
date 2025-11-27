<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Produk extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'rating',
    ];

    public function gambarCover()
    {
        // Asumsi Anda ingin gambar pertama berdasarkan id/urutan pembuatan
        return $this->hasOne(GambarProduk::class);
    }

    public function gambarProduks()
    {
        return $this->hasMany(GambarProduk::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'produk_tag', 'produk_id', 'tag_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function itemPesanans()
    {
        return $this->hasMany(ItemPesanan::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}

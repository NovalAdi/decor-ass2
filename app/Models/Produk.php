<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'rating',
    ];

    public function gambarProduks()
    {
        return $this->hasMany(GambarProduk::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'produk_tag');
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

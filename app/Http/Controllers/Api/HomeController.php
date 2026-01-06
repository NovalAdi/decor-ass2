<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $produk = Produk::withAvg('reviews', 'rating')
            ->with(['gambarProduks:id,produk_id,gambar'])
            ->get()
            ->each(function ($item) {
                $item->rating = round($item->reviews_avg_rating ?? 0, 1);
                $item->gambar = $item->gambarProduks->first()->gambar ?? null;

                unset($item->reviews_avg_rating, $item->gambarProduks);
            });
        return response()->json([
            'status' => true,
            'message' => 'Welcome to the API Home Endpoint',
            'data' => $produk,
        ]);
    }

    public function detail($id)
    {
        $produk = Produk::with([
            'tags:id,nama',
            'gambarProduks:id,produk_id,gambar'
        ])
            ->withAvg('reviews', 'rating')
            ->find($id);

        if (!$produk) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $produk->rating = round($produk->reviews_avg_rating ?? 0, 1);
        $produk->gambar = $produk->gambarProduks->first()->gambar ?? null;

        unset($produk->reviews_avg_rating);
        unset($produk->gambarProduks);

        return response()->json([
            'status' => true,
            'message' => 'Product details retrieved successfully',
            'data' => $produk
        ]);
    }
}

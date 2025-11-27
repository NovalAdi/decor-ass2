<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Review;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with(['gambarProduks' => function ($query) {
            $query->limit(1);
        }])->get();
        return view('page.produk', compact('produks'));
    }

    public function show(string $id)
    {
        $produk = Produk::with(['gambarProduks', 'tags'])
                        ->findOrFail($id);

        $reviews = Review::with(['user', 'gambarReviews'])
                         ->where('produk_id', $produk->id)
                         ->latest()
                         ->get();

        $averageRating = $produk->reviews->avg('rating');
        $reviewCount = $produk->reviews->count();
        $roundedRating = round($averageRating, 1);

        return view('page.detail_product', [
            'produk' => $produk,
            'reviews' => $reviews,
            'reviewCount' => $reviewCount,
            'roundedRating' => $roundedRating,
        ]);
    }
}

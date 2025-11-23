<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Review;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::with(['gambarProduks' => function ($query) {
            $query->limit(1);
        }])->get();
        return view('page.produk', compact('produks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 1. Ambil produk dengan relasi yang diperlukan (Gambar, Tag, Review)
        $produk = Produk::with(['gambarProduks', 'tags'])
                        ->findOrFail($id);

        // 2. Ambil ulasan, termasuk pengguna yang memberi ulasan dan gambar ulasan
        $reviews = Review::with(['user', 'gambarReviews'])
                         ->where('produk_id', $produk->id)
                         ->latest()
                         ->paginate(5); // Paginasi untuk ulasan

        // 3. Hitung rating rata-rata (sudah ada di model, tapi kita hitung ulang untuk statistik)
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        //
    }
}

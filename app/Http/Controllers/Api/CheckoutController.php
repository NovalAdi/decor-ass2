<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ItemPesanan;
use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function showCheckout(Request $request)
    {
        $selectedIds = $request->input('products', []);

        $cartItems = Cart::whereIn('id', $selectedIds)
            ->with('produk.gambarProduks')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'produk_id' => $item->produk_id,
                    'nama_produk' => $item->produk->nama,
                    'harga' => $item->produk->harga,
                    'quantity' => $item->quantity,
                    'gambar' => $item->produk->gambarProduks->first()->gambar ?? null,
                    'total_harga' => $item->produk->harga * $item->quantity,
                ];
            });

        return response()->json([
            'status' => true,
            'data' => [
                'cart_items' => $cartItems,
                'total_harga_cart' => $cartItems->sum('total_harga'),
                'alamats' => Auth::user()->alamats,
            ]
        ], 200);
    }

    public function checkout(Request $request)
    {

        $pesanan = Pesanan::create([
            'user_id' => Auth::id(),
            'total_harga' => $request->total_harga,
            'status' => 'menunggu pembayaran',
            'tgl_pesan' => now(),
            'alamat' => '',
            'jenis_pembayaran' => $request->payment,
            'jenis_pengiriman' => $request->shipping,
        ]);

        foreach ($request->products as $productId) {
            $cart = Cart::where('id', $productId)
                ->where('user_id', Auth::id())
                ->first();

            if (!$cart) {
                continue; // skip kalau cart tidak ditemukan
            }

            ItemPesanan::create([
                'pesanan_id' => $pesanan->id,
                'produk_id' => $cart->produk_id,
                'quantity' => $cart->quantity,
            ]);

            $cart->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Checkout berhasil',
            'data' => [
                'pesanan_id' => $pesanan->id,
                'total' => $pesanan->total_harga,
                'status' => $pesanan->status,
            ]
        ], 201);
    }
    public function store(Request $request)
    {

        Pembayaran::create([
            'pesanan_id' => $request->pesanan_id,
            'tgl_pembayaran' => now(),
        ]);

        $pesanan = Pesanan::find($request->pesanan_id);
        $pesanan->status = 'diproses';
        $pesanan->save();

        return response()->json([
            'status' => true,
            'message' => 'Pembayaran berhasil',
            'data' => [
                'pesanan_id' => $pesanan->id,
                'status' => $pesanan->status,
            ]
        ], 201);
    }
}

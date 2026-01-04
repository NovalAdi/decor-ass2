<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ItemPesanan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartApiController extends Controller
{
    // 1️⃣ LIHAT CART
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('produk.gambarProduks')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'produk_id' => $item->produk_id,
                    'nama_produk' => $item->produk->nama,
                    'harga' => $item->produk->harga,
                    'quantity' => $item->quantity,
                    'total_harga' => $item->produk->harga * $item->quantity,
                ];
            });

        return response()->json([
            'cart' => $cartItems,
            'total_harga' => $cartItems->sum('total_harga'),
        ]);
    }

    // 2️⃣ TAMBAH KE CART
    public function store(Request $request, $id)
    {
        $cartItem = Cart::firstOrNew([
            'produk_id' => $id,
            'user_id'   => Auth::id(),
        ]);

        $cartItem->quantity += $request->input('quantity', 1);
        $cartItem->save();

        return response()->json([
            'message' => 'Produk berhasil ditambahkan ke cart',
            'data' => $cartItem
        ], 201);
    }

    // 3️⃣ UPDATE JUMLAH (PLUS / MINUS)
    public function update(Request $request, $id)
    {
        $cartItem = Cart::find($id);

        if (!$cartItem) {
            return response()->json(['message' => 'Item tidak ditemukan'], 404);
        }

        if ($request->type === 'plus') {
            $cartItem->quantity += 1;
        } elseif ($request->type === 'minus' && $cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
        }

        $cartItem->save();

        return response()->json([
            'message' => 'Cart berhasil diupdate',
            'data' => $cartItem
        ]);
    }

    // 4️⃣ HAPUS DARI CART
    public function destroy($id)
    {
        $cartItem = Cart::find($id);

        if ($cartItem) {
            $cartItem->delete();
        }

        return response()->json([
            'message' => 'Item berhasil dihapus'
        ]);
    }

    // 5️⃣ CHECKOUT → CREATE PESANAN
    public function checkout(Request $request)
    {
        $pesanan = Pesanan::create([
            'user_id' => Auth::id(),
            'total_harga' => $request->total_harga,
            'status' => 'menunggu pembayaran',
            'tgl_pesan' => now(),
            'jenis_pembayaran' => $request->payment,
            'jenis_pengiriman' => $request->shipping,
        ]);

        foreach ($request->products as $cartId) {
            $cart = Cart::find($cartId);

            ItemPesanan::create([
                'pesanan_id' => $pesanan->id,
                'produk_id' => $cart->produk_id,
                'quantity' => $cart->quantity,
            ]);

            $cart->delete();
        }

        return response()->json([
            'message' => 'Pesanan berhasil dibuat',
            'pesanan' => $pesanan
        ], 201);
    }
}

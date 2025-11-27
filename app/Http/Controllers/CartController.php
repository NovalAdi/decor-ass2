<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\ItemPesanan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::user()->id)
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

        // Hitung total
        $totalHargaCart = $cartItems->sum('total_harga');

        return view('page.cart', compact('cartItems', 'totalHargaCart'));
    }

    public function showCheckout(Request $request)
    {
        $selectedIds = $request->input('products', []);

        if (empty($selectedIds)) {
            return redirect()->route('cart.index');
        }

        $cartItems = Cart::whereIn('id', $selectedIds)
            ->with('produk.gambarProduks')
            ->get()
            ->map(function ($item) {
                return [
                    'id'          => $item->id,
                    'produk_id'   => $item->produk_id,
                    'nama_produk' => $item->produk->nama,
                    'harga'       => $item->produk->harga,
                    'quantity'    => $item->quantity,
                    'gambar' => $item->produk->gambarProduks->first()->gambar ?? null,
                    'total_harga' => $item->produk->harga * $item->quantity,
                ];
            });

        $totalHargaCart = $cartItems->sum('total_harga');
        $totalItem = $cartItems->sum('quantity');
        $alamats = Auth::user()->alamats;

        return view('page.checkout', compact('cartItems', 'totalHargaCart', 'totalItem', 'alamats'));
    }

    public function checkout(Request $request)
    {
        $pesanan = Pesanan::create([
            'user_id' => Auth::id(),
            'total_harga' => $request->total_harga,
            'status' => 'menunggu pembayaran',
            'tgl_pesan' => now(),
            'alamat' => $request->alamat,
            'jenis_pembayaran' => $request->payment,
            'jenis_pengiriman' => $request->shipping,
        ]);

        foreach ($request->input('products', []) as $productId) {
            $cart = Cart::where('id', $productId)->first();

            ItemPesanan::create([
                'pesanan_id' => $pesanan->id,
                'produk_id' => $cart->produk_id,
                'quantity' => $cart->quantity,
            ]);

            Cart::where('id', $productId)->delete();
        }

        return redirect()->route('pembayaran.show', $pesanan->id);
    }

    public function store(Request $request, $id)
    {
        $cartItem = Cart::firstOrNew([
            'produk_id' => $id,
            'user_id'   => Auth::id(),
        ]);

        $cartItem->quantity += $request->input('quantity', 1); // jika baru akan otomatis mulai dari null jadi 1
        $cartItem->save();

        return redirect()->route('cart.index');
    }

    public function update($type, $id)
    {
        $cartItem = Cart::find($id);

        if ($cartItem) {
            if ($type === 'plus') {
                $cartItem->quantity += 1;
            } elseif ($type === 'minus' && $cartItem->quantity > 1) {
                $cartItem->quantity -= 1;
            }
            $cartItem->save();
        }

        return redirect()->route('cart.index');
    }

    public function destroy($id)
    {
        $cartItem = Cart::find($id);

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function showCheckout(Request $request)
    {
        $selectedIds = $request->input('products', []);

        if (empty($selectedIds)) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada produk yang dipilih.');
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

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cartItem = Cart::find($id);

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.index');
    }
}

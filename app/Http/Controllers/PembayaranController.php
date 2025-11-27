<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function store(Request $request)
    {
        Pembayaran::create([
            'pesanan_id' => $request->input('pesanan_id'),
            'tgl_pembayaran' => now(),
        ]);

        $pesanan = Pesanan::find($request->input('pesanan_id'));
        $pesanan->status = 'diproses';
        $pesanan->save();

        return redirect()->route('home');
    }

    public function show($id)
    {
        $pesanan = Pesanan::where('id', $id)->first();

        $deadline = $pesanan->created_at->addHours(24);

        return view('page.pembayaran', compact('deadline', 'pesanan'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        Pembayaran::create([
            'pesanan_id' => $request->input('pesanan_id'),
            'tgl_pembayaran' => now(),
        ]);

        $pesanan = Pesanan::find($request->input('pesanan_id'));
        $pesanan->status = 'diproses';
        $pesanan->save();

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pesanan = Pesanan::where('id', $id)->first();

        $deadline = $pesanan->created_at->addHours(24);

        return view('page.pembayaran', compact('deadline', 'pesanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
}

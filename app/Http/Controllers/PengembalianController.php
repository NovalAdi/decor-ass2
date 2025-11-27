<?php

namespace App\Http\Controllers;

use App\Models\GambarPengembalian;
use App\Models\Pengembalian;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function store(Request $request)
    {
        $pengembalian = Pengembalian::create([
            'pesanan_id' => $request->input('pesanan_id'),
            'tipe' => $request->input('tipe'),
            'judul' => $request->input('judul'),
            'deskripsi' => $request->input('deskripsi'),
        ]);

        Pesanan::where('id', $request->input('pesanan_id'))->update(['status' => 'pengembalian']);

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $gambar) {
                $path = $gambar->store('pengembalian', 'public');
                GambarPengembalian::create([
                    'pengembalian_id' => $pengembalian->id,
                    'gambar' => $path,
                ]);
            }
        }

        return redirect()->route('home');
    }

    public function show($id)
    {
        return view('page.pengembalian', compact('id'));
    }
}

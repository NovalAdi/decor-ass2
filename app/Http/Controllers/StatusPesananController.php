<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class StatusPesananController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status ?? 'menunggu pembayaran';

        $pesanans = Pesanan::where('user_id', Auth::id())
            ->where('status', $status)
            ->with('itemPesanans.produk')
            ->orderBy('tgl_pesan', 'DESC')
            ->get();

        return view('page.track_pesanan', compact('pesanans', 'status'));
    }

    public function konfirmasiPembayaran($id)
    {
        $pesanan = Pesanan::where('user_id', Auth::id())->findOrFail($id);

        // Jika status masih menunggu pembayaran baru bisa konfirmasi
        if ($pesanan->status == 'menunggu pembayaran') {
            $pesanan->status = 'diproses';
            $pesanan->save();
        }

        return redirect()->route('pesanan.index', ['status' => 'diproses'])
            ->with('success', 'Pembayaran telah dikonfirmasi!');
    }
}

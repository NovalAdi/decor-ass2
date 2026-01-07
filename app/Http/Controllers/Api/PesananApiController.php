<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Pesanan;

class PesananApiController extends Controller
{
    // GET /api/pesanans?status=menunggu pembayaran
    public function index(Request $request)
    {
        $status = $request->only('status')['status'] ?? 'menunggu pembayaran';

        $pesanans = Pesanan::where('user_id', Auth::user()->id)
            ->with('itemPesanans.produk')
            ->orderBy('tgl_pesan', 'DESC')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pesanans
        ]);
    }

    public function update(Request $request, $id)
    {
        $pesanan = Pesanan::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'status' => 'required|string|in:menunggu pembayaran,diproses,dikirim,selesai,batal',
        ]);

        $pesanan->status = $request->status;
        $pesanan->save();

        return response()->json([
            'success' => true,
            'message' => 'Status pesanan berhasil diperbarui',
            'data' => $pesanan
        ]);
    }
}

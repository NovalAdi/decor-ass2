<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alamat;
use Illuminate\Support\Facades\Auth;

class AlamatApiController extends Controller
{
    // GET /api/alamats
    public function index()
    {
        $alamats = Alamat::where('user_id', Auth::user()->id)->get();

        return response()->json([
            'success' => true,
            'data' => $alamats
        ]);
    }

    // POST /api/alamats
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        $alamat = Alamat::create([
            'user_id' => Auth::user()->id,
            'judul' => $request->judul,
            'alamat' => $request->alamat,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil ditambahkan',
            'data' => $alamat
        ], 201);
    }

    // GET /api/alamats/{id}
    public function show(Request $request, $id)
    {
        $alamat = Alamat::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $alamat
        ]);
    }

    // PUT /api/alamats/{id}
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        $alamat = Alamat::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $alamat->update($request->only('judul', 'alamat'));

        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil diperbarui',
            'data' => $alamat
        ]);
    }

    // DELETE /api/alamats/{id}
    public function destroy(Request $request, $id)
    {
        $alamat = Alamat::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $alamat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil dihapus'
        ]);
    }
}

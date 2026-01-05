<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    // GET: Menampilkan semua produk
    public function index()
    {
        $produks = Produk::all();
        return response()->json([
            'success' => true,
            'data'    => $produks
        ], 200);
    }

    // POST: Menyimpan produk baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga'     => 'required|numeric',
            'stok'      => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
       
        $produk = Produk::create($request->all());
        return response()->json(['message' => 'Produk berhasil ditambahkan', 'data' => $produk], 201);
    }

    // GET {id}: Menampilkan satu produk detail
    public function show($id)
    {
        $produk = Produk::find($id);
        if (!$produk) return response()->json(['message' => 'Data tidak ditemukan'], 404);
        
        return response()->json(['success' => true, 'data' => $produk], 200);
    }

    // PUT/PATCH: Mengupdate produk
    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);
        if (!$produk) return response()->json(['message' => 'Data tidak ditemukan'], 404);

        $produk->update($request->all());
        return response()->json(['message' => 'Produk berhasil diupdate', 'data' => $produk], 200);
    }

    // DELETE: Menghapus produk
    public function destroy($id)
    {
        $produk = Produk::find($id);
        if (!$produk) return response()->json(['message' => 'Data tidak ditemukan'], 404);

        $produk->delete();
        return response()->json(['message' => 'Produk berhasil dihapus'], 200);
    }
}

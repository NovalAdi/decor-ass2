<?php


namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    // Tampil semua tag
    public function index() {
        return response()->json(Tag::all(), 200);
    }

    // Simpan tag baru
    public function store(Request $request) {
        $request->validate(['nama' => 'required|unique:tags,nama']);
        $tag = Tag::create($request->all());
        return response()->json($tag, 201);
    }

    // Tampil satu tag beserta produk yang memakainya
    public function show($id) {
        $tag = Tag::with('produks')->find($id);
        if (!$tag) return response()->json(['message' => 'Tag tidak ditemukan'], 404);
        return response()->json($tag, 200);
    }

    // Update tag
    public function update(Request $request, $id) {
        $tag = Tag::find($id);
        if (!$tag) return response()->json(['message' => 'Tag tidak ditemukan'], 404);
        $tag->update($request->all());
        return response()->json($tag, 200);
    }

    // Hapus tag
    public function destroy($id) {
        $tag = Tag::find($id);
        if (!$tag) return response()->json(['message' => 'Tag tidak ditemukan'], 404);
        $tag->delete();
        return response()->json(['message' => 'Tag dihapus'], 200);
    }
}
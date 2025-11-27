<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Menampilkan halaman Kelola Tag/Kategori untuk Admin. (READ)
     */
    public function indexAdmin()
    {
        $tags = Tag::withCount('produks')->paginate(10);
        return view('admin.tag.index', compact('tags'));
    }

    /**
     * Menampilkan form untuk membuat Tag baru. (CREATE - Form)
     */
    public function createAdmin()
    {
        return view('admin.tag.create');
    }

    /**
     * Menyimpan Tag baru ke database. (CREATE - Store)
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Tag::create($request->all());

        return redirect()->route('admin.tag.index')->with('success', 'Tag/Kategori berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit Tag yang spesifik. (UPDATE - Form)
     */
    public function editAdmin(Tag $tag)
    {
        return view('admin.tag.edit', compact('tag'));
    }

    /**
     * Memperbarui Tag yang spesifik di database. (UPDATE - Store)
     */
    public function updateAdmin(Request $request, Tag $tag)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $tag->update($request->all());

        return redirect()->route('admin.tag.index')->with('success', 'Tag/Kategori berhasil diperbarui.');
    }

    /**
     * Menghapus Tag yang spesifik dari database. (DELETE)
     */
    public function destroyAdmin(Tag $tag)
    {
        // Tag dihapus, relasi di tabel 'produk_tag' juga akan otomatis dihapus (cascade)
        $tag->delete();
        return redirect()->route('admin.tag.index')->with('success', 'Tag/Kategori berhasil dihapus.');
    }
}
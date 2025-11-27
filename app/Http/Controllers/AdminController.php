<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan; // Pastikan model Pesanan diimpor

class AdminController extends Controller
{
    // ------------------------------------------------------------------------------------------------
    // FUNGSI KELOLA PRODUK (CRUD)
    // ------------------------------------------------------------------------------------------------

    /**
     * Menampilkan daftar semua produk (Index).
     */
    public function produkIndex()
    {
        // Mengambil produk dan tag terkait untuk Kelola Produk
        $produks = Produk::with('tags')->paginate(10);
        return view('admin.produk.index', compact('produks'));
    }

    /**
     * Menampilkan form untuk menambah produk baru.
     */
    public function produkCreate()
    {
        $tags = Tag::all(); // Ambil semua tag/kategori untuk dropdown
        return view('admin.produk.create', compact('tags'));
    }

    /**
     * Menyimpan produk baru ke database (Store).
     */
    public function produkStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:produks,nama',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            // 'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Jika upload gambar diaktifkan
        ]);

        try {
            DB::beginTransaction();

            $produk = Produk::create([
                'nama' => $validated['nama'],
                'harga' => $validated['harga'],
                'stok' => $validated['stok'],
                'deskripsi' => $validated['deskripsi'] ?? null,
            ]);

            if (isset($validated['tags'])) {
                $produk->tags()->sync($validated['tags']);
            }

            // [TODO: Logika Penyimpanan Gambar]

            DB::commit();

            return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menambahkan produk: ' . $e->getMessage());
        }
    }


    /**
     * Menampilkan form Edit produk yang sudah ada.
     * Menggunakan Route Model Binding ($produk otomatis terisi dari ID di URL).
     */
    public function produkEdit(Produk $produk)
    {
        // Ambil semua tag
        $tags = Tag::all();
        // Ambil ID tag yang sudah terpasang pada produk ini
        $produkTags = $produk->tags->pluck('id')->toArray();

        return view('admin.produk.edit', compact('produk', 'tags', 'produkTags'));
    }

    /**
     * Memproses dan menyimpan perubahan produk ke database (Update).
     */
    public function produkUpdate(Request $request, Produk $produk)
    {
        // 1. Validasi Data
        $validated = $request->validate([
            // Rule unique di sini diubah: boleh sama dengan nama produk itu sendiri ($produk->id)
            'nama' => ['required', 'string', 'max:255', Rule::unique('produks')->ignore($produk->id)],
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        try {
            // 2. Update Data Produk
            $produk->update([
                'nama' => $validated['nama'],
                'harga' => $validated['harga'],
                'stok' => $validated['stok'],
                'deskripsi' => $validated['deskripsi'] ?? null,
            ]);

            // 3. Sinkronisasi Tags (Relasi Many-to-Many)
            $produk->tags()->sync($validated['tags'] ?? []);

            // [TODO: Logika Update Gambar]

            return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }


    /**
     * Menghapus produk dari database (Destroy).
     */
    public function produkDestroy(Produk $produk)
    {
        try {
            $namaProduk = $produk->nama;

            // Detach tags sebelum menghapus produk utama
            $produk->tags()->detach();
            $produk->delete();

            return redirect()->route('admin.produk.index')->with('success', 'Produk "' . $namaProduk . '" berhasil dihapus!');
        } catch (\Exception $e) {
             return back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    // ------------------------------------------------------------------------------------------------
    // FUNGSI KELOLA PESANAN (sudah ada sebelumnya)
    // ------------------------------------------------------------------------------------------------

    /**
     * Menampilkan halaman Kelola Pesanan.
     */
    public function pesananIndex()
    {
        // Mengambil pesanan dan user (customer) terkait untuk Kelola Pesanan
        $pesanans = Pesanan::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pesanan.index', compact('pesanans'));
    }

    /**
     * Mengubah status pesanan.
     */
    public function updateStatusPesanan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        try {
            $pesanan = Pesanan::findOrFail($id);
            $pesanan->status = $request->status;
            $pesanan->save();

            return back()->with('success', 'Status pesanan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui status pesanan: ' . $e->getMessage());
        }
    }
}

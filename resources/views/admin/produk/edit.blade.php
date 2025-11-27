@extends('layout.master_admin')

{{-- Menggunakan nama produk sebagai title --}}
@section('title', 'Edit Produk: ' . $produk->nama)

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Produk: <span class="text-orange-600">{{ $produk->nama }}</span></h1>

<div class="bg-white shadow-lg rounded-xl p-8 max-w-4xl mx-auto">
    {{-- Form mengarah ke produkUpdate menggunakan metode PUT --}}
    {{-- $produk->id akan otomatis terdeteksi oleh route admin.produk.update --}}
    <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- PENTING: Gunakan metode PUT untuk update --}}

        {{-- Menampilkan error validasi --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">Error Validasi!</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nama Produk --}}
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                {{-- Menggunakan old('nama', $produk->nama) untuk mempertahankan input lama jika ada error, atau menampilkan data lama --}}
                <input type="text" name="nama" id="nama" value="{{ old('nama', $produk->nama) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border @error('nama') border-red-500 @enderror">
            </div>

            {{-- Harga --}}
            <div>
                <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="harga" id="harga" value="{{ old('harga', $produk->harga) }}" required min="0"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border @error('harga') border-red-500 @enderror">
            </div>
            
            {{-- Stok --}}
            <div>
                <label for="stok" class="block text-sm font-medium text-gray-700 mb-1">Stok <span class="text-red-500">*</span></label>
                <input type="number" name="stok" id="stok" value="{{ old('stok', $produk->stok) }}" required min="0"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border @error('stok') border-red-500 @enderror">
            </div>

            {{-- Kategori (Tags) --}}
            <div>
                <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">Kategori (Pilih Multiple)</label>
                {{-- Variabel $tags dilewatkan dari AdminController::produkEdit() --}}
                <select name="tags[]" id="tags" multiple
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border h-32 @error('tags') border-red-500 @enderror">
                    @foreach ($tags as $tag)
                        {{-- Logika untuk menandai tag yang sudah terpilih: cek apakah $tag->id ada di array $produkTags (yang sudah diload di Controller) --}}
                        <option value="{{ $tag->id }}" 
                            @if(in_array($tag->id, old('tags', $produkTags))) selected @endif>
                            {{ $tag->nama }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500">Tahan Ctrl/Cmd untuk memilih lebih dari satu kategori.</p>
            </div>
        </div>
        
        {{-- Deskripsi --}}
        <div class="mt-6">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            {{-- Menggunakan $produk->deskripsi untuk nilai default --}}
            <textarea name="deskripsi" id="deskripsi" rows="4"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
        </div>

        {{-- Bagian Gambar Produk (Sama dengan form Tambah, perlu logika khusus untuk update gambar) --}}
        <div class="mt-6 p-4 border border-gray-200 rounded-md bg-gray-50">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Produk Saat Ini</label>
            {{-- Tampilkan gambar yang sudah ada (hanya placeholder visual) --}}
            <div class="flex flex-wrap gap-3 mb-4">
                @if ($produk->gambarProduks->count() > 0)
                    @foreach ($produk->gambarProduks as $gambar)
                        {{-- Placeholder: ganti dengan <img src="{{ asset('storage/' . $gambar->path) }}" ...> --}}
                        <div class="text-xs text-gray-500 bg-gray-200 p-2 rounded-md border border-gray-300">
                            Gambar #{{ $loop->iteration }} ({{ $gambar->nama ?? 'Nama File' }})
                        </div>
                    @endforeach
                @else
                    <p class="text-sm text-gray-500">Belum ada gambar yang diunggah.</p>
                @endif
            </div>

            <label for="gambar" class="block text-sm font-semibold text-gray-700 mb-2">Unggah Gambar Baru (Akan menggantikan yang lama)</label>
            <input type="file" name="gambar[]" id="gambar" multiple class="block w-full text-sm text-gray-500">
            <p class="mt-1 text-xs text-gray-500">Pilih gambar baru. Saat ini, logika upload file di Controller hanya berupa *placeholder*.</p>
        </div>

        {{-- Tombol Submit dan Batal --}}
        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ route('admin.produk.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-md">
                Batal
            </a>
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md flex items-center">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
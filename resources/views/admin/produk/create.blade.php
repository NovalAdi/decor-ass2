@extends('layout.master_admin')

@section('title', 'Tambah Produk Baru')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Produk Baru</h1>

<div class="bg-white shadow-lg rounded-xl p-8 max-w-4xl mx-auto">
    {{-- Form mengarah ke produkStore --}}
    {{-- PENTING: Jika Anda ingin mengupload file/gambar, tambahkan enctype="multipart/form-data" --}}
    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

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
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border @error('nama') border-red-500 @enderror">
            </div>

            {{-- Harga --}}
            <div>
                <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="harga" id="harga" value="{{ old('harga') }}" required min="0"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border @error('harga') border-red-500 @enderror">
            </div>
            
            {{-- Stok --}}
            <div>
                <label for="stok" class="block text-sm font-medium text-gray-700 mb-1">Stok <span class="text-red-500">*</span></label>
                <input type="number" name="stok" id="stok" value="{{ old('stok') }}" required min="0"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border @error('stok') border-red-500 @enderror">
            </div>

            {{-- Kategori (Tags) --}}
            <div>
                <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">Kategori (Pilih Multiple)</label>
                {{-- Variabel $tags dilewatkan dari AdminController::produkCreate() --}}
                <select name="tags[]" id="tags" multiple
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border h-32 @error('tags') border-red-500 @enderror">
                    @foreach ($tags as $tag)
                        {{-- Menggunakan 'nama' karena model Tag.php menggunakan kolom nama --}}
                        <option value="{{ $tag->id }}" @if(in_array($tag->id, old('tags', []))) selected @endif>
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
            <textarea name="deskripsi" id="deskripsi" rows="4"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
        </div>

        {{-- Input Gambar Produk --}}
        <div class="mt-6 p-4 border border-gray-200 rounded-md bg-gray-50">
            <label for="gambar" class="block text-sm font-semibold text-gray-700 mb-2">Unggah Gambar Produk</label>
            <input type="file" name="gambar[]" id="gambar" multiple class="block w-full text-sm text-gray-500">
            <p class="mt-1 text-xs text-gray-500">Saat ini, logika upload file belum ditambahkan di Controller, namun input form sudah tersedia.</p>
        </div>

        {{-- Tombol Submit dan Batal --}}
        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ route('admin.produk.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-md">
                Batal
            </a>
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md flex items-center">
                Simpan Produk
            </button>
        </div>
    </form>
</div>
@endsection
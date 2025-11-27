@extends('layout.master_admin')

@section('title', 'Kelola Tag / Kategori')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6">Daftar Tag & Kategori Produk</h1>

{{-- Menampilkan pesan sukses dari sesi --}}
@if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        <p>{{ session('success') }}</p>
    </div>
@endif

<div class="flex justify-end mb-6">
    {{-- BARIS YANG DIPERBAIKI: Menggunakan route('admin.tag.create') --}}
    <a href="{{ route('admin.tag.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md flex items-center">
        <i class="fas fa-plus mr-2"></i> Tambah Tag/Kategori
    </a>
</div>

<div class="bg-white shadow-lg rounded-xl p-6">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tag / Kategori</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Produk Terkait</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($tags as $tag)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                            {{ $tag->nama }}
                        </span>
                    </td>
                    {{-- produks_count dihitung di TagController::indexAdmin() --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $tag->produks_count }} produk</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        
                        {{-- TAUTAN EDIT: Menggunakan route admin.tag.edit dengan ID tag --}}
                        <a href="{{ route('admin.tag.edit', $tag->id) }}" class="text-orange-500 hover:text-orange-700 mr-3 inline-block">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        {{-- FORM HAPUS: Menggunakan route admin.tag.destroy dengan ID tag dan method DELETE --}}
                        <form action="{{ route('admin.tag.destroy', $tag->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tag {{ $tag->nama }}? Tindakan ini tidak dapat dibatalkan.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada tag/kategori ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4 flex justify-end">
        {{ $tags->links('pagination::tailwind') }}
    </div>
</div>
@endsection
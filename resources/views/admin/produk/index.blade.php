@extends('layout.master_admin')

@section('title', 'Kelola Produk')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6">Kelola Produk</h1>

<div class="flex justify-end mb-6">
    <a href="{{ route('admin.produk.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md flex items-center">
        <i class="fas fa-plus mr-2"></i> Tambah Produk
    </a>
</div>

<div class="bg-white shadow-lg rounded-xl p-6">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($produks as $produk)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $produk->nama }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ $produk->stok }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @forelse ($produk->tags as $tag)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $tag->nama }}
                            </span>
                        @empty
                            -
                        @endforelse
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        {{-- **INI BARIS KRITISNYA:** Memastikan link mengarah ke rute edit dengan ID produk --}}
                        <a href="{{ route('admin.produk.edit', $produk->id) }}" class="text-orange-500 hover:text-orange-700 mr-3 inline-block">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        {{-- Form Hapus Produk (Tempat Sampah) --}}
                        <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $produk->nama }}? Tindakan ini tidak dapat dibatalkan.');">
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
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada produk ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4 flex justify-between items-center">
        <p class="text-sm text-gray-700">
            Showing {{ $produks->firstItem() }} to {{ $produks->lastItem() }} of {{ $produks->total() }} results
        </p>
        {{ $produks->links('pagination::tailwind') }}
    </div>
</div>
@endsection
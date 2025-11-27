@extends('layout.master_admin')

@section('title', 'Kelola Pesanan')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6">Kelola Pesanan</h1>

<div class="bg-white shadow-lg rounded-xl p-6">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Customer</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($pesanans as $pesanan)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">ORD{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pesanan->user->name ?? 'Pengguna Dihapus' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <form action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}" method="POST" id="status-form-{{ $pesanan->id }}">
                            @csrf
                            <select name="status" onchange="document.getElementById('status-form-{{ $pesanan->id }}').submit()"
                                class="border rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500 text-sm py-1 px-2
                                @if($pesanan->status == 'menunggu pembayaran') bg-yellow-100 text-yellow-800 border-yellow-300
                                @elseif($pesanan->status == 'diproses') bg-blue-100 text-blue-800 border-blue-300
                                @elseif($pesanan->status == 'dikirim') bg-indigo-100 text-indigo-800 border-indigo-300
                                @elseif($pesanan->status == 'selesai') bg-green-100 text-green-800 border-green-300
                                @elseif($pesanan->status == 'pengembalian') bg-red-100 text-red-800 border-red-300
                                @else bg-gray-100 text-gray-800 border-gray-300
                                @endif
                                ">
                                @foreach (['menunggu pembayaran', 'diproses', 'dikirim', 'selesai', 'pengembalian'] as $status)
                                    <option value="{{ $status }}" @if($pesanan->status == $status) selected @endif>{{ $status }}</option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="#" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-1.5 px-3 rounded-lg text-xs">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada pesanan ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $pesanans->links('pagination::tailwind') }}
    </div>
</div>
@endsection

@extends('layout.master')

@section('content')
    <div class="bg-gray-100 py-24">

        <div class="container mx-auto px-8 py-6">

            <!-- Title -->
            <h2 class="text-2xl font-bold mb-6">Daftar Pesanan</h2>

            <!-- Status Tabs -->
            <div class="flex gap-3 mb-8">
                @php
                    $tabs = [
                        'menunggu pembayaran' => 'Konfirmasi',
                        'diproses' => 'Diproses',
                        'dikirim' => 'Dikirim',
                        'pengembalian' => 'Pengembalian',
                        'selesai' => 'Selesai',
                    ];
                @endphp

                @foreach ($tabs as $key => $label)
                    <a href="{{ route('pesanan.index', ['status' => $key]) }}"
                        class="px-4 py-1 rounded-full border
                    {{ $status == $key ? 'bg-[#C59059] text-white border-[#C59059]' : 'bg-white text-gray-700' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <!-- List Pesanan -->
            @foreach ($pesanans as $p)
                <div class="bg-white p-5 rounded-xl shadow mb-6 border border-gray-100 flex justify-between items-start">

                    <div class="flex flex-col">
                        <!-- Tanggal & Status -->
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-sm text-gray-600">{{ date('d M Y', strtotime($p->tgl_pesan)) }}</span>

                            <span class="text-xs bg-gray-200 text-gray-700 px-3 py-1 rounded-full">
                                {{ ucfirst($p->status) }}
                            </span>
                        </div>

                        <!-- Produk -->
                        @foreach ($p->itemPesanans as $item)
                            <div class="flex items-center gap-3 mb-3">
                                <img src="{{ $item->produk->gambarProduks->first()->gambar ? $item->produk->gambarProduks->first()->gambar : asset('img/default_product.png') }}"
                                    class="h-20 w-20 object-cover rounded-lg border" alt="">
                                <div class="flex flex-col gap-1 items-start">
                                    <p class="font-semibold">{{ $item->produk->nama }}</p>
                                    <p class="text-sm text-gray-600">Rp
                                        {{ number_format($item->produk->harga, 0, ',', '.') }}
                                        x {{ $item->quantity }}</p>
                                    @if ($p->status == 'selesai')
                                        <a href="{{ route('review.show', $item->produk->id) }}"
                                            class="rounded py-1 px-4 text-sm bg-[#B5733A] text-white hover:bg-[#9a5e2e]">review</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <!-- Total -->
                        <p class="mt-4 font-semibold">
                            Total : Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                        </p>
                    </div>

                    <!-- Kanan -->
                    <div class="flex flex-col items-end gap-3">
                        <span class="text-sm text-gray-700">Id Pesanan : {{ $p->id }}</span>

                        @if ($p->status == 'menunggu pembayaran')
                            <a href="{{ route('pesanan.konfirmasi', $p->id) }}"
                                class="bg-[#C59059] text-white px-4 py-2 rounded-lg text-sm shadow">
                                Konfirmasi Pembayaran
                            </a>
                        @elseif ($p->status == 'diproses')
                            <a href="{{ route('pengembalian.show', $p->id) }}"
                                class="bg-[#C59059] text-white px-4 py-2 rounded-lg text-sm shadow">
                                Pengembalian Pesanan
                            </a>
                        @endif
                    </div>

                </div>
            @endforeach

        </div>

    </div>
@endsection

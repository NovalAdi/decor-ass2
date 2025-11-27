<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

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
                    'tiba ditujuan' => 'Tiba di tujuan',
                    'complain' => 'Complain',
                    'selesai' => 'Selesai'
                ];
            @endphp

            @foreach ($tabs as $key => $label)
                <a href="{{ route('pesanan.index', ['status' => $key]) }}" class="px-4 py-1 rounded-full border 
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
                    <div class="flex items-center gap-3">
                        <img src="/img/sofa.png" class="w-14" alt="">
                        <div>
                            <p class="font-semibold">{{ $p->produk_nama ?? 'Produk' }}</p>
                            <span class="text-sm text-gray-600">Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                                x1</span>
                        </div>
                    </div>

                    <!-- Total -->
                    <p class="mt-4 font-semibold">
                        Total : Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Kanan -->
                <div class="flex flex-col items-end gap-3">
                    <span class="text-sm text-gray-700">Id Pesanan : {{ $p->id }}</span>

                    @if($p->status == 'menunggu pembayaran')
                        <a href="{{ route('pembayaran.konfirmasi', $p->id) }}"
                            class="bg-[#C59059] text-white px-4 py-2 rounded-lg text-sm shadow">
                            Konfirmasi Pembayaran
                        </a>
                    @endif
                </div>

            </div>
        @endforeach

    </div>

</body>

</html>
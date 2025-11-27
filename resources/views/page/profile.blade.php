@extends('layout.master')

@section('content')
<div class="bg-gray-50 py-24">

    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-lg p-6 sm:p-8">

        {{-- Header Selamat Datang --}}
        <div class="flex items-center p-4 bg-white border-b border-gray-200 rounded-t-lg mb-6">
            <img src="{{ $user->gambar ? asset('storage/' . $user->gambar) : asset('img/default_pp.png') }}"
                alt="Avatar" class="w-12 h-12 rounded-full mr-4 object-cover">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">Halo, {{ $user->name }}!</h1>
                <p class="text-sm text-gray-500">Selamat datang kembali di Decor.</p>
            </div>
        </div>

        {{-- Informasi Pribadi --}}
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-700">Informasi Pribadi</h2>
                <a href="{{ route('profile.edit') }}"
                    class="text-sm text-gray-600 border border-gray-300 py-1 px-3 rounded-md hover:bg-gray-100 transition duration-150">
                    Edit Profil
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Lengkap --}}
                <div>
                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-500 mb-1">Username</label>
                    <input type="text" id="nama_lengkap" value="{{ $user->name }}" readonly
                        class="w-full bg-gray-100 border border-gray-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:border-yellow-500">
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                    <input type="email" id="email" value="{{ $user->email }}" readonly
                        class="w-full bg-gray-100 border border-gray-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:border-yellow-500">
                </div>

                {{-- Nomor Telepon --}}
                <div class="md:col-span-1">
                    <label for="nomor_telepon" class="block text-sm font-medium text-gray-500 mb-1">Nomor
                        Telepon</label>
                    <input type="text" id="nomor_telepon" value="{{ $user->no_hp}}" readonly
                        class="w-full bg-gray-100 border border-gray-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:border-yellow-500">
                </div>
            </div>
        </div>

        <hr class="my-6 border-gray-200">

        {{-- Akses Cepat --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Akses Cepat</h2>
            <div class="flex space-x-4">
                {{-- Tombol Alamat Pengiriman --}}
                <a href="{{ route('alamat.index') }}"
                    class="flex text-white items-center bg-decor py-3 px-6 rounded-full font-medium shadow-md transition duration-200 hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243m10.606 0a8 8 0 10-11.233-11.233 8 8 0 0011.233 11.233z">
                        </path>
                    </svg>
                    Alamat Pengiriman
                </a>

                {{-- Tombol Riwayat Pesanan --}}
                <a href="{{ route("pesanan.index") }}"
                    class="flex items-center bg-decor text-white py-3 px-6 rounded-full font-medium shadow-md transition duration-200 hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Riwayat Pesanan
                </a>
            </div>
        </div>

    </div>

</div>
@endsection

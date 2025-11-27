@extends('layout.master')

@section('content')
    <div class="bg-gray-50 py-24">

        <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-lg p-6 sm:p-8">

            {{-- Header Edit Profil --}}
            <div class="flex items-center p-4 bg-white border-b border-gray-200 rounded-t-lg mb-6">

                <div>
                    <h1 class="text-xl font-semibold text-gray-800">Edit Profil</h1>
                    <p class="text-sm text-gray-500">Ubah informasi pribadi Anda.</p>
                </div>
            </div>

            {{-- Form Edit Profil --}}
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Edit Foto Profil --}}
                    <div class="flex flex-col items-center mb-6">
                        <div class="relative group">
                            <img src="{{ $user->gambar ? asset('storage/' . $user->gambar) : asset('img/default_pp.png') }}"
                                alt="Foto Profil"
                                class="w-28 h-28 rounded-full object-cover border-4 border-gray-200 shadow-md">

                            <!-- Hover overlay -->
                            <div
                                class="absolute inset-0 rounded-full bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                <label for="gambar"
                                    class="text-white text-sm cursor-pointer font-medium bg-yellow-400 px-3 py-1 rounded-full shadow hover:bg-yellow-500 transition">
                                    Ganti Foto
                                </label>
                            </div>
                        </div>

                        <input type="file" id="gambar" name="gambar" class="hidden" onchange="previewImage(event)">

                        <p class="text-xs text-gray-400 mt-2">*Format: JPG, PNG • Max 2MB</p>
                    </div>

                    {{-- Preview Image Script --}}
                    <script>
                        function previewImage(event) {
                            const image = document.querySelector('img[alt="Foto Profil"]');
                            image.src = URL.createObjectURL(event.target.files[0]);
                        }
                    </script>

                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-500 mb-1">Username</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:border-yellow-500">
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:border-yellow-500">
                    </div>

                    {{-- Nomor Telepon --}}
                    <div class="md:col-span-1">
                        <label for="phone_number" class="block text-sm font-medium text-gray-500 mb-1">Nomor Telepon</label>
                        <input type="text" id="phone_number" name="no_hp"
                            value="{{ old('phone_number', $user->no_hp) }}"
                            class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 text-gray-700 focus:outline-none focus:border-yellow-500">
                    </div>

                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-end space-x-4 pt-4">
                    <a href="{{ route('profile.index') }}"
                        class="py-2 px-6 rounded-full border border-gray-300 text-gray-600 hover:bg-gray-100 transition">
                        Batal
                    </a>

                    <button type="submit"
                        class="btn-decor py-2 px-6 rounded-full font-medium shadow-md hover:shadow-lg transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection

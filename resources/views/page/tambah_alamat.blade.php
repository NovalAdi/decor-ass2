@extends('layout.master')

@section('content')
<div class="bg-gray-50 py-24">

    <div class="max-w-3xl mx-auto bg-white rounded-lg p-6 sm:p-8 shadow">

        <h1 class="text-2xl font-semibold text-gray-800 mb-8">Tambah Alamat Baru</h1>

        <form action="{{ route('alamat.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-700 font-medium mb-2">Judul Alamat</label>
                <input type="text" name="judul" required placeholder="Contoh: Rumah, Kantor"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 focus:outline-none">
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-medium mb-2">Alamat Lengkap</label>
                <textarea name="alamat" rows="5" required placeholder="Masukkan alamat lengkap..."
                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-yellow-500 focus:outline-none"></textarea>
            </div>

            <div class="flex justify-end space-x-3 mt-8">
                <a href="{{ route('alamat.index') }}" class="btn-back">Batal</a>
                <button type="submit" class="btn-submit">Simpan Alamat</button>
            </div>

        </form>

    </div>

</div>
@endsection

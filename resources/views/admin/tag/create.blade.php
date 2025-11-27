@extends('layout.master_admin')

@section('title', 'Tambah Tag / Kategori Baru')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Tag / Kategori Baru</h1>

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

<div class="bg-white shadow-lg rounded-xl p-6 max-w-lg mx-auto">
    {{-- Form mengarah ke TagController::storeAdmin() --}}
    <form action="{{ route('admin.tag.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Tag / Kategori <span class="text-red-500">*</span></label>
            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 p-2 border @error('nama') border-red-500 @enderror"
                   placeholder="Contoh: Sofa Minimalis atau Pencahayaan">
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('admin.tag.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-md">
                Batal
            </a>
            <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md flex items-center">
                <i class="fas fa-save mr-2"></i> Simpan Tag
            </button>
        </div>
    </form>
</div>
@endsection
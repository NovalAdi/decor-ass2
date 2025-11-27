@extends('layout.master')

@section('content')
    <div class="bg-gray-50 py-24">

        <div class="max-w-4xl mx-auto bg-white rounded-lg p-6 sm:p-8">

            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-semibold text-gray-800">Daftar Alamat Saya</h1>
                <a href="{{ route('alamat.create') }}" class="btn-tambah flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Alamat Baru
                </a>
            </div>

            <div class="space-y-6">

                @foreach ($addresses as $address)
                    <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm flex justify-between items-start">
                        <div>
                            <div class="flex items-center mb-1">
                                <h3 class="text-lg font-medium text-gray-900 mr-3">{{ $address->judul }}</h3>
                            </div>

                            <p class="text-sm text-gray-600 mt-1">{{ $address->alamat }}</p>
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('alamat.edit', $address->id) }}" class="btn-action btn-edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                    </path>
                                </svg>
                            </a>

                            <form action="{{ route('alamat.destroy', $address->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn-action btn-delete" onclick="return confirm('Hapus alamat ini?')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach

            </div>

        </div>

    </div>
@endsection

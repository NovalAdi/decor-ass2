@extends('layout.master')

@section('content')
    <div class="my-24 container mx-auto px-20">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            <div class="product-gallery">
                <div class="main-image mb-4">
                    @if ($produk->gambarProduks->first())
                        <img src="{{ $produk->gambarProduks->first()->gambar }}" alt="{{ $produk->nama }} - Gambar Utama"
                            class="w-full h-auto rounded-xl shadow-lg object-cover">
                    @endif
                </div>

                <div class="thumbnail-strip flex space-x-3 overflow-x-auto p-1">
                    @foreach ($produk->gambarProduks as $gambar)
                        <img src="{{ $gambar->gambar }}" alt="{{ $produk->nama }} Thumbnail"
                            class="w-20 h-20 object-cover border border-gray-200 rounded-lg cursor-pointer transition duration-150"
                            style="--hover-border-color: #B5733A; --hover-shadow-color: rgba(181, 115, 58, 0.5); border: 2px solid transparent;"
                            onmouseover="this.style.borderColor = this.style.getPropertyValue('--hover-border-color'); this.style.boxShadow = '0 0 0 3px ' + this.style.getPropertyValue('--hover-shadow-color')"
                            onmouseout="this.style.borderColor = 'transparent'; this.style.boxShadow = 'none'">
                    @endforeach
                </div>
            </div>

            <div class="product-info">

                <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $produk->nama }}</h1>

                <div class="flex items-center mb-4">
                    <span class="text-gray-500">({{ $reviewCount }} Ulasan)</span>
                </div>

                <p class="text-5xl font-extrabold mb-6" style="color: #B5733A;">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </p>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Deskripsi Produk</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $produk->deskripsi }}</p>
                </div>

                <div class="mb-8">
                    @foreach ($produk->tags as $tag)
                        <span
                            class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
                            #{{ $tag->nama }}
                        </span>
                    @endforeach
                </div>

                <form action="{{ route('cart.add', $produk->id) }}" method="POST" class="flex space-x-4">
                    @csrf

                    <input type="number" name="quantity" value="1" min="1"
                        class="w-20 p-2 border border-gray-300 rounded-lg text-center @guest opacity-50 cursor-not-allowed @endguest"
                        @guest disabled @endguest />

                    <button type="submit"
                        class="flex-1 text-white font-bold py-3 px-6 rounded-lg transition duration-300 @guest opacity-50 cursor-not-allowed @endguest"
                        style="background-color: #B5733A; box-shadow: 0 4px 6px -1px rgba(181, 115, 58, 0.5);"
                        onmouseover="this.style.backgroundColor = '@auth #9e6230 @else #B5733A @endauth';"
                        onmouseout="this.style.backgroundColor = '#B5733A';" @guest disabled @endguest>
                        <i class="fas fa-shopping-cart mr-2"></i> Tambahkan ke Keranjang
                    </button>
                </form>

                @guest
                    <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        ⚠️ Silakan <a href="/login" class="font-semibold text-blue-400">Login</a>
                        untuk menambahkan produk ke keranjang.
                    </div>
                @endguest
            </div>
        </div>

        <hr class="my-12">

        <div id="reviews" class="mt-10">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Ulasan Pelanggan</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="p-6 rounded-xl flex flex-col items-center justify-center" style="background-color: #B5733A10;">
                    <p class="text-6xl font-extrabold" style="color: #B5733A;">{{ $roundedRating }}</p>
                    <p class="text-lg text-gray-500 mt-1">{{ $reviewCount }} Total Ulasan</p>
                </div>
            </div>

            <div class="space-y-6">
                @forelse ($reviews as $review)
                    <div class="border-b pb-4">
                        <div class="flex items-center mb-2">
                            <p class="font-bold text-gray-800 mr-3">{{ $review->user->nama }}</p>
                            <span style="color: #B5733A;">
                                @for ($i = 0; $i < $review->rating; $i++)
                                    ⭐
                                @endfor
                            </span>
                            <span class="ml-auto text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-600 mb-2">{{ $review->review }}</p>

                        @if ($review->gambarReviews->isNotEmpty())
                            <div class="flex space-x-2 mt-2">
                                @foreach ($review->gambarReviews as $gbr)
                                    <img src="{{ Str::startsWith($gbr->gambar, 'http') ? $gbr->gambar : asset('storage/' . $gbr->gambar) }}"
                                        class="w-16 h-16 object-cover rounded-md border" alt="Gambar Review">
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada ulasan untuk produk ini.</p>
                @endforelse

                {{-- <div class="mt-4">
                    {{ $reviews->links() }}
                </div> --}}
            </div>
        </div>
    </div>
@endsection

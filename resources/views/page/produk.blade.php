@extends('layout.master')

@section('content')
    <section class="grid grid-cols-4 py-3 mt-20">
        <!-- filter -->
        <aside
            class="flex flex-col p-10 gap-3 drop-shadow-md bg-white ml-14 mr-7 rounded-xl border border-[1px] border-gray-200 h-min">
            <h1 class="text-2xl font-medium">Filter</h1>
            <div>
                <h1 class="font-medium">Categories</h1>
                <div class="ml-2 text-gray-700 mt-3">
                    <div class="flex gap-3 items-center">
                        <input type="checkbox" name="" id="">
                        <p>Sofa</p>
                    </div>
                    <div class="flex gap-3 items-center">
                        <input type="checkbox" name="" id="">
                        <p>Table</p>
                    </div>
                    <div class="flex gap-3 items-center">
                        <input type="checkbox" name="" id="">
                        <p>Wardrope</p>
                    </div>
                    <div class="flex gap-3 items-center">
                        <input type="checkbox" name="" id="">
                        <p>Bed</p>
                    </div>
                    <div class="flex gap-3 items-center">
                        <input type="checkbox" name="" id="">
                        <p>Lamp</p>
                    </div>
                </div>
            </div>
            <div>
                <h1 class="font-medium">Style</h1>
                <div class="ml-2 text-gray-700 mt-3">
                    <div class="flex gap-3 items-center">
                        <input type="checkbox" name="" id="">
                        <p>Scandinavian</p>
                    </div>
                    <div class="flex gap-3 items-center">
                        <input type="checkbox" name="" id="">
                        <p>Industial</p>
                    </div>
                    <div class="flex gap-3 items-center">
                        <input type="checkbox" name="" id="">
                        <p>Japandi</p>
                    </div>
                </div>
            </div>
            <div>
                <h1 class="font-medium">Rating</h1>
                <div class="ml-2 text-gray-700 mt-3 flex flex-col gap-1">
                    <div class="flex gap-3 items-center">
                        <input type="checkbox" name="" id="">
                        <div class="flex gap-1 items-center">
                            <img class="w-[15px] h-[15px]" src="/img/star.png" alt="">
                            <img class="w-[15px] h-[15px]" src="/img/star.png" alt="">
                            <img class="w-[15px] h-[15px]" src="/img/star.png" alt="">
                            <img class="w-[15px] h-[15px]" src="/img/star.png" alt="">
                            <img class="w-[15px] h-[15px]" src="/img/star.png" alt="">
                            <p>(5)</p>
                        </div>
                    </div>
                    <div class="flex gap-3 items-center">
                        <input type="checkbox" name="" id="">
                        <div class="flex gap-1 items-center">
                            <img class="w-[15px] h-[15px]" src="/img/star.png" alt="">
                            <img class="w-[15px] h-[15px]" src="/img/star.png" alt="">
                            <img class="w-[15px] h-[15px]" src="/img/star.png" alt="">
                            <img class="w-[15px] h-[15px]" src="/img/star.png" alt="">
                            <p>(4)</p>
                        </div>
                    </div>
                    <div class="flex gap-3 items-center">
                        <input type="checkbox" name="" id="">
                        <div class="flex gap-1 items-center">
                            <img class="w-[15px] h-[15px]" src="/img/star.png" alt="">
                            <img class="w-[15px] h-[15px]" src="/img/star.png" alt="">
                            <img class="w-[15px] h-[15px]" src="/img/star.png" alt="">
                            <p>(3)</p>
                        </div>
                    </div>
                    <div class="flex gap-3 items-center">
                        <input type="checkbox" name="" id="">
                        <div class="flex gap-1 items-center">
                            <img class="w-[15px] h-[15px]" src="/img/star.png" alt="">
                            <img class="w-[15px] h-[15px]" src="/img/star.png" alt="">
                            <p>(2)</p>
                        </div>
                    </div>
                    <div class="flex gap-3 items-center">
                        <input type="checkbox" name="" id="">
                        <div class="flex gap-1 items-center">
                            <img class="w-[15px] h-[15px]" src="/img/star.png" alt="">
                            <p>(1)</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-3">
                <h1 class="font-medium">Filter by Price</h1>
                <div class="flex">
                    <input type="text" placeholder="From"
                        class="p-2 border-l-[1.5px] border-y-[1.5px] border-gray-400 rounded-l-lg text-sm w-full">
                    <p class="flex items-center border border-[1.5px] border-gray-400 rounded-r-lg px-2">Rp</p>
                </div>
                <div class="flex">
                    <input type="text" placeholder="To"
                        class="p-2 border-l-[1.5px] border-y-[1.5px] border-gray-400 rounded-l-lg text-sm w-full">
                    <p class="flex items-center border border-[1.5px] border-gray-400 rounded-r-lg px-2">Rp</p>
                </div>
            </div>
            <button type="submit" class="mt-3 w-full text-white py-2 rounded-lg bg-[#B5733A]">Filter</button>
        </aside>

        <main class="col-span-3 mr-14">

            <!-- sort -->
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-medium">Show {{ count($produks) }} product</h1>
                <div class="flex items-center gap-3">
                    <p>Sort by</p>
                    <select class="px-2 py-1 border border-[1.5px] border-gray-400 rounded-lg text-sm">
                        <option value="">Price</option>
                        <option value="">Style</option>
                        <option value="">Category</option>
                    </select>
                </div>
            </div>

            <!-- list -->
            <section class="grid grid-cols-4 gap-3 mt-5">
                @foreach ($produks as $produk)
                    <a class="pb-1 bg-white hover:bg-gray-100 overflow-hidden flex flex-col gap-3 rounded-lg"
                        href="{{ route('produk.show', $produk['id']) }}">
                        <div class="relative">
                            <img class="bg-gray-200 w-full h-[250px] object-cover"
                                src="{{ $produk->gambarProduks->first()->gambar ?? '' }}" alt="">
                        </div>
                        <div class="flex flex-col justify-between gap-2 h-full px-4 pb-2">
                            <div>
                                <h1 class="w-full line-clamp-2">{{ $produk['nama'] }}</h1>
                                <p class="font-bold mt-2">Rp {{ number_format($produk['harga'], 0, ',', '.') }}</p>
                            </div>
                            <div class="flex gap-2 items-center">
                                <img class="w-[15px] h-[15px]" src="{{ asset('img/star.png') }}" alt="">
                                <p>{{ round($produk->reviews->avg('rating'), 1) }} | {{ $produk->reviews->count() ?? 0 }} reviews</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </section>

            <!-- pagination -->
            @if (count($produks) != 0)
                <div class="flex gap-14 items-center text-lg mt-10 justify-center">
                    <div class="flex gap-5">
                        <a href=""><i class="fa-solid fa-angles-left"></i></a>
                        <a href=""><i class="fa-solid fa-angle-left"></i></a>
                    </div>
                    <div class="flex gap-3">
                        <a href="" class="underline underline-offset-8">1</a>
                        <a href="">2</a>
                        <a href="">3</a>
                        <a href="">4</a>
                        <a href="">5</a>
                        <a href="">...</a>
                        <a href="">25</a>
                    </div>
                    <div class="flex gap-5">
                        <a href=""><i class="fa-solid fa-angle-right"></i></a>
                        <a href=""><i class="fa-solid fa-angles-right"></i></a>
                    </div>
                </div>
            @endif
        </main>
    </section>

    <!-- banner -->
    <section class="grid grid-cols-2 gap-10 px-16 mb-20 mt-10">
        <div
            class="bg-[url('../../img/indus-2.jpg')] bg-center bg-no-repeat bg-cover h-[200px] rounded-xl overflow-hidden">
            <div class="bg-gray-900/30 w-full h-full flex justify-center items-center p-20">
                <h1 class="tracking-wider text-3xl font-bold text-white text-center">Explore Our Exclusive Annual Sale
                </h1>
            </div>
        </div>
        <div class="bg-[url('../../img/jp-2.png')] bg-center bg-no-repeat bg-cover h-[200px] rounded-xl overflow-hidden">
            <div class="bg-gray-900/30 w-full h-full flex justify-center items-center p-20">
                <h1 class="tracking-wider text-3xl font-bold text-white text-center">Enjoy Big Discounts in Our Mid-Year
                    Deals</h1>
            </div>
        </div>
    </section>
@endsection

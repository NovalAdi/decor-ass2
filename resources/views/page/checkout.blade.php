@extends('layout.master')


@section('content')
    {{-- Kontainer utama checkout --}}
    <div class="min-h-screen bg-gray-50 py-10">

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf

            {{-- Container utama yang membagi layout menjadi dua kolom besar untuk desktop --}}
            <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row gap-8 mt-12 mb-16">

                {{-- Left Section: Alamat, Produk, dan Pengiriman (Lebar 3/5) --}}
                <div class="lg:w-3/5 space-y-8">

                    {{-- 1. Shipping Address --}}
                    <section class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl font-bold text-gray-900 mb-5 flex items-center gap-3">
                                <span class="text-[#B5733A]">📦</span> Shipping Address
                            </h2>
                            <a href="{{ route('alamat.create') }}" class="text-[#B5733A] underline">Add new Address</a>
                        </div>
                        <select name="alamat" id="shipping_address"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-700
                                 focus:border-[#B5733A] appearance-none">
                            @forelse ($alamats as $data)
                                <option value="{{ $data->alamat }}" class="p-2">
                                    {{ $data->judul }} - {{ $data->alamat }}
                                </option>
                            @empty
                                <option value="" disabled selected class="p-2">Please add a shipping address
                                </option>
                            @endforelse
                        </select>
                        {{-- Catatan: Anda mungkin ingin menambahkan tombol 'Add New Address' di sini --}}
                    </section>

                    {{-- 2. Product List and Shipping Method --}}
                    <section class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-900 mb-5 flex items-center gap-3">
                            <span class="text-[#B5733A]">🛒</span> Order Details
                        </h2>

                        <div class="store-block">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-3 mb-4">Decor Official Store</h3>

                            {{-- Product Items --}}
                            <div class="space-y-4">
                                @foreach ($cartItems as $data)
                                    <div
                                        class="flex items-start gap-4 p-2 hover:bg-gray-50 rounded-lg transition duration-100">
                                        <img src="{{ $data['gambar'] }}" alt="{{ $data['nama_produk'] }}"
                                            class="w-16 h-16 object-cover rounded-md shadow-sm border">
                                        <div class="flex-grow">
                                            <p class="font-medium text-gray-800">{{ $data['nama_produk'] }}</p>
                                            <span class="text-sm text-gray-500">
                                                {{ $data['quantity'] }} x Rp{{ number_format($data['harga'], 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <span class="font-semibold text-gray-900 flex-shrink-0 text-right">
                                            Rp{{ number_format($data['quantity'] * $data['harga'], 0, ',', '.') }}
                                        </span>
                                        <input type="hidden" name="products[]" value="{{ $data['id'] }}">
                                    </div>
                                @endforeach
                            </div>

                            <hr class="my-6 border-gray-200">

                            {{-- Shipping Options --}}
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                <span class="text-[#B5733A]">🚚</span> Shipping Options
                            </h3>

                            <div class="space-y-3">

                                {{-- 1. Cargo Option (Default Selected) --}}
                                <div class="shipping-option">
                                    <label
                                        class="flex items-start gap-3 p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="shipping" value="cargo" checked required
                                            class="mt-1.5 text-[#B5733A] h-5 w-5 border-gray-300">
                                        <div class="flex-grow">
                                            <p class="font-medium text-gray-800">Cargo
                                            </p>
                                            <p class="text-sm text-gray-500">Estimate Arrived 25-27 Jan</p>
                                        </div>
                                    </label>
                                </div>

                                {{-- 2. Economi Option --}}
                                <div class="shipping-option">
                                    <label
                                        class="flex items-start gap-3 p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="shipping" value="economi"
                                            class="mt-1.5 text-[#B5733A] h-5 w-5 border-gray-300">
                                        <div class="flex-grow">
                                            <p class="font-medium text-gray-800">Economi
                                            </p>
                                            <p class="text-sm text-gray-500">Estimate Arrived 7 - 11 Jan</p>
                                        </div>
                                    </label>
                                </div>

                                {{-- 3. Instan Option --}}
                                <div class="shipping-option">
                                    <label
                                        class="flex items-start gap-3 p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                        <input type="radio" name="shipping" value="instan"
                                            class="mt-1.5 text-[#B5733A] h-5 w-5 border-gray-300">
                                        <div class="flex-grow">
                                            <p class="font-medium text-gray-800">Instan (Arrived at the same day)
                                            </p>
                                            <p class="text-sm text-gray-500">Arrived Today</p>
                                        </div>
                                    </label>
                                </div>

                            </div>
                        </div>
                    </section>
                </div>

                {{-- Right Section: Pembayaran dan Summary (Lebar 2/5) --}}
                <div class="lg:w-2/5 space-y-8">
                    <div class="sticky top-21">

                        {{-- 3. Payment Method --}}
                        <section class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-5 flex items-center gap-3">
                                <span class="text-[#B5733A]">💳</span> Payment Method
                            </h2>

                            <div class="space-y-3">

                                {{-- 1. BCA Virtual Account (Required) --}}
                                <label
                                    class="flex items-center justify-between p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment" value="bca" required
                                            class="focus:ring-[#B5733A] text-[#B5733A] h-5 w-5 border-gray-300">
                                        <img src="https://images.tokopedia.net/img/payment/icons/bca.png"
                                            alt="BCA Virtual Account" class="w-8 h-auto object-contain">
                                        <h3 class="font-medium text-gray-700">BCA Virtual Account</h3>
                                    </div>
                                </label>

                                {{-- 2. Gopay --}}
                                <label
                                    class="flex items-center justify-between p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment" value="gopay"
                                            class="focus:ring-[#B5733A] text-[#B5733A] h-5 w-5 border-gray-300">
                                        <img src="https://images.tokopedia.net/img/payment/icons/gopay.png" alt="Gopay"
                                            class="w-8 h-auto object-contain">
                                        <h3 class="font-medium text-gray-700">Gopay</h3>
                                    </div>
                                </label>

                                {{-- 3. COD (Cash On Delivery) --}}
                                <label
                                    class="flex items-center justify-between p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment" value="cod"
                                            class="focus:ring-[#B5733A] text-[#B5733A] h-5 w-5 border-gray-300">
                                        <h3 class="font-medium text-gray-700">COD (Cash On Delivery)</h3>
                                    </div>
                                </label>

                            </div>
                        </section>

                        {{-- 4. Order Summary --}}
                        <section class="bg-white p-6 rounded-xl shadow-2xl border border-gray-200">
                            <h2 class="text-2xl font-bold text-gray-900 mb-5 flex items-center gap-3">
                                <span class="text-[#B5733A]">💰</span> Order Summary
                            </h2>

                            <div class="space-y-3 text-gray-700">
                                {{-- Subtotal --}}
                                <div class="flex justify-between">
                                    <span>Total Price ({{ $totalItem }} Items)</span>
                                    <span class="font-medium">
                                        Rp{{ number_format($totalHargaCart, 0, ',', '.') }}
                                    </span>
                                </div>

                                {{-- Grand Total --}}
                                <div class="pt-3 flex justify-between font-bold text-xl text-gray-900">
                                    <span>Grand Total</span>
                                    <span class="text-[#B5733A]" id="grand-total-display">
                                        Rp{{ number_format($totalHargaCart, 0, ',', '.') }}
                                    </span>
                                    <input type="hidden" name="total_harga" value="{{ $totalHargaCart }}">
                                </div>
                            </div>

                            {{-- Checkout Button --}}
                            <button type="submit"
                                class="mt-6 w-full text-white py-3 rounded-lg bg-[#B5733A] hover:bg-amber-800
                                       transition duration-300 font-semibold text-lg uppercase tracking-wider shadow-md
                                       focus:outline-none focus:ring-4/50"
                                value="Checkout" name="btnCheckout">
                                Proceed to Checkout
                            </button>
                        </section>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

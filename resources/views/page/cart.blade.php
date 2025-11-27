@extends('layout.master')

@section('content')
    <div class="mt-24 mb-24">

        <form action="{{ route('checkout.show') }}" method="POST" class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @csrf

            <h1 class="text-3xl font-bold text-gray-900 mb-8 border-b pb-3">Your Cart</h1>

            <section class="overflow-x-auto bg-white rounded-xl shadow-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr class="text-left text-sm font-semibold uppercase tracking-wider text-gray-600">
                            <th class="py-4 pl-6 w-1/2">Product</th>
                            <th class="py-4 text-center w-1/6">Price</th>
                            <th class="py-4 text-center w-1/6">Quantity</th>
                            <th class="py-4 text-right w-1/6 pr-6">Total</th>
                            <th class="py-4 pr-6"></th> {{-- Delete button column --}}
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @if ($cartItems && count($cartItems) > 0)
                            @foreach ($cartItems as $item)
                                <tr class="item-cart hover:bg-gray-50 transition duration-150">
                                    {{-- PRODUCT --}}
                                    <td class="py-4 pl-6">
                                        <div class="flex items-center gap-4">
                                            {{-- Checkbox for Checkout --}}
                                            <input type="checkbox" name="products[]" value="{{ $item['id'] }}"
                                                class="h-5 w-5 text-[#B5733A] border-gray-300 rounded focus:ring-[#B5733A]">

                                            <img src="{{ $item['gambar'] }}" alt="{{ $item['nama_produk'] }}"
                                                class="w-20 h-20 rounded-lg object-cover border border-gray-100 shadow-sm">

                                            <h1 class="font-medium text-gray-800">{{ $item['nama_produk'] }}</h1>
                                        </div>
                                    </td>

                                    {{-- PRICE --}}
                                    <td class="text-center text-gray-600">
                                        <p>Rp{{ number_format($item['harga'], 0, ',', '.') }}</p>
                                    </td>

                                    {{-- QUANTITY --}}
                                    <td class="text-center">
                                        <div class="flex items-center justify-center space-x-0">
                                            <a href="{{ route('cart.update', ['type' => 'minus', 'id' => $item['id']]) }}"
                                                class="flex items-center justify-center h-8 w-8 text-xl text-gray-600 bg-gray-100 rounded-l-md hover:bg-gray-200 transition duration-150 border border-r-0 border-gray-300">
                                                -
                                            </a>
                                            <input type="text"
                                                class="qty-input w-12 h-8 text-center bg-white text-gray-700 border-y border-gray-300 focus:outline-none"
                                                readonly value="{{ $item['quantity'] }}">
                                            <a href="{{ route('cart.update', ['type' => 'plus', 'id' => $item['id']]) }}"
                                                class="flex items-center justify-center h-8 w-8 text-xl text-gray-600 bg-gray-100 rounded-r-md hover:bg-gray-200 transition duration-150 border border-l-0 border-gray-300">
                                                +
                                            </a>
                                        </div>
                                    </td>

                                    {{-- TOTAL (Item) --}}
                                    <td class="text-right font-semibold text-gray-900 pr-6">
                                        <p>Rp{{ number_format($item['total_harga'], 0, ',', '.') }}</p>
                                    </td>

                                    {{-- DELETE --}}
                                    <td class="text-center pr-6">
                                        <a href="{{ route('cart.delete', ['id' => $item['id']]) }}"
                                            class="text-gray-400 hover:text-red-500 transition duration-150 font-semibold text-lg"
                                            title="Remove Item">
                                            &times;
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            {{-- Cart Empty State --}}
                            <tr class="h-20 bg-white">
                                <td colspan="5" class="text-center py-8 text-gray-500 text-lg">
                                    <p>Your cart is empty. Let's find something great!</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </section>

            @if ($cartItems && count($cartItems) > 0)
                <section class="mt-8 flex justify-end">
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 w-full max-w-sm">
                        <div class="flex justify-between items-center mb-4">
                            <h1 class="text-xl font-semibold text-gray-800">Grand Total</h1>
                            <p class="text-2xl font-bold text-[#B5733A]">
                                Rp{{ number_format($totalHargaCart, 0, ',', '.') }}
                            </p>
                        </div>

                        <button type="submit"
                            class="w-full mt-3 px-4 py-3 text-white font-semibold rounded-lg bg-[#B5733A] border-2 border-[#B5733A] hover:bg-amber-800 transition duration-300 shadow-md">
                            Proceed to Checkout
                        </button>
                        <p class="text-xs text-gray-500 mt-2 text-center">
                            *Only selected items will be processed.
                        </p>
                    </div>
                </section>
            @endif
        </form>
    </div>
@endsection

@extends('layout.master')

@section('content')
    <div class="bg-gray-50 font-sans text-gray-700 pt-24">

        <div class="container mx-auto px-4 py-10">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-800">Complete Your Payment</h2>
                <p class="text-gray-500 mt-2">Please make a transfer before the time runs out.</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8 max-w-6xl mx-auto">

                <div class="w-full lg:w-2/3">
                    <div
                        class="bg-white rounded-xl shadow-sm p-6 mb-6 border-l-4 border-decor flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">Payment Deadline</p>
                            <p class="font-bold text-gray-800">
                                {{ $deadline->translatedFormat('d F H:i') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Time Left</p>
                            <div id="countdown" class="text-xl font-bold text-red-500">Loading...</div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-8">
                        <h3 class="text-xl font-bold mb-6">Bank Transfer (BCA)</h3>

                        <div
                            class="flex justify-between items-center bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
                            <div>
                                <p class="text-sm text-gray-500">Virtual Account Number</p>
                                <p class="text-2xl font-mono font-bold text-gray-800 tracking-wider">8801 2345 6789</p>
                            </div>
                            <button onclick="copyToClipboard()"
                                class="text-decor font-semibold text-sm hover:underline">Copy</button>
                        </div>

                        <div class="flex justify-between items-center mb-6">
                            <p class="text-gray-600">Total Amount</p>
                            <p class="text-2xl font-bold text-decor">
                                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <form action="{{ route('pembayaran.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="pesanan_id" value="{{ $pesanan->id }}">

                            <button type="submit"
                                class="w-full bg-decor text-white font-bold py-4 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                                I Have Completed Payment
                            </button>
                        </form>
                    </div>
                </div>

                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-xl shadow-sm p-6 sticky top-10">
                        <h3 class="text-lg font-bold mb-4">📦 Order Summary</h3>

                        <div class="flex justify-between border-t pt-4">
                            <span class="font-bold text-lg">Grand Total</span>
                            <span class="font-bold text-lg text-decor">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        var countDownDate = new Date("{{ $deadline }}").getTime();
        var x = setInterval(function() {
            var now = new Date().getTime();
            var distance = countDownDate - now;
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById("countdown").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "EXPIRED";
            }
        }, 1000);

        function copyToClipboard() {
            navigator.clipboard.writeText("880123456789");
            alert("VA Number Copied!");
        }
    </script>
@endsection

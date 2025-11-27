<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - @yield('title')</title>
    <!-- Gunakan link Tailwind CSS atau framework CSS yang Anda gunakan -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .active-link {
            border-bottom: 2px solid #f97316; /* Orange-500 */
            color: #f97316;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="container mx-auto px-4 py-4">
            <nav class="flex justify-start space-x-6 text-gray-600">
                <a href="{{ route('admin.produk.index') }}" class="py-2 hover:text-orange-500 @if(request()->routeIs('admin.produk.*')) active-link @endif">Kelola Produk</a>
                <a href="{{ route('admin.tag.index') }}" class="py-2 hover:text-orange-500 @if(request()->routeIs('admin.tag.*')) active-link @endif">Kelola Tag / Kategori</a>
                <a href="{{ route('admin.pesanan.index') }}" class="py-2 hover:text-orange-500 @if(request()->routeIs('admin.pesanan.*')) active-link @endif">Kelola Pesanan</a>
                <div class="flex-grow"></div>
                <a href="{{ route('logout') }}" class="py-2 text-red-500 hover:text-red-700">Logout</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white shadow mt-10">
        <div class="container mx-auto px-4 py-4 text-center text-gray-500 text-sm">
            © 2025 Decor Admin Tables. All rights reserved.
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
<header class="fixed top-0 w-full py-5 flex justify-between items-center px-5 md:px-10 bg-white/85 z-10">
    <div class="w-full flex flex-col sm:flex-row sm:items-center sm:w-max gap-5 sm:gap-10">
        <div class="flex justify-between w-full">
            <div class="flex items-center gap-3">
                <div>
                    <a href="{{ url('../home') }}">
                        <img width="100px" src="{{ asset('img/logo-decor.svg') }}" class="p-1" alt="">
                    </a>
                    @onlyAdmin
                    <p class="text-sm font-bold text-[#B5733A]">Admin</p>
                    @endonlyAdmin
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <div class="sm:flex flex-col sm:flex-row sm:items-end gap-5 sm:gap-10 inactive-burger">
            @php
                $authUser = auth('admin')->user() ?? auth('web')->user();
                $routes =
                    $authUser && $authUser->is_admin == 1
                    ? [
                        [
                            'name' => 'Products',
                            'path' => '/admin-produk',
                        ],
                        [
                            'name' => 'Tags',
                            'path' => '/admin-tags',
                        ],
                    ]
                    : [
                        [
                            'name' => 'Home',
                            'path' => '/home',
                        ],
                        [
                            'name' => 'Products',
                            'path' => '/produk',
                        ],
                        [
                            'name' => 'Contact',
                            'path' => '/contact-us',
                        ],
                    ];
            @endphp

            @foreach ($routes as $route)
                <div class="flex h-full items-start text-gray-700 text-sm sm:text-base">
                    <a href="{{ url($route['path']) }}" class="hover:text-[#B5733A]">
                        {{ $route['name'] }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="sm:flex items-center gap-7 text-xl text-gray-700 hidden">
        @guestAndUser
        <form method="post" action="" class="relative w-full max-w-md">
            @csrf
            <div
                class="flex items-center bg-white border border-gray-300 rounded-full overflow-hidden shadow-sm focus-within:ring-2 focus-within:ring-[#B5733A] transition">
                <i class="fa-solid fa-magnifying-glass px-4 text-gray-500"></i>
                <input type="text" name="search_query" value="{{ session('search_query') ?? '' }}"
                    placeholder="Search for products..." class="flex-1 py-2 pr-10 text-sm focus:outline-none">
                <input type="submit" class="hidden">
                @if (!empty(session('search_query')))
                    <button type="submit" name="clearSearch" value="1"
                        class="px-3 text-gray-400 hover:text-black transition" title="Clear search">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                @endif
            </div>
        </form>
        @endguestAndUser

        @guestAny
        <div class="sm:flex items-center gap-3 text-xl text-gray-700 hidden">
            <a href="{{ route('login') }}">
                <button
                    class="rounded py-1 px-4 text-sm bg-[#B5733A] text-white hover:bg-[#9a5e2e] transition-all">Masuk</button>
            </a>
            <a href="{{ route('register') }}">
                <button
                    class="rounded py-1 px-4 text-sm bg-[#B5733A] text-white hover:bg-[#9a5e2e] transition-all">Daftar</button>
            </a>
        </div>
        @endguestAny

        @auth
        @onlyUser
        <a href="{{ url('/cart') }}"><i class="fa-solid fa-cart-shopping"></i></a>
        @endonlyUser
        <div class="relative group w-10 h-10 shrink-0">
            @if ($authUser && $authUser->gambar)
                <img class="rounded-full w-full h-full object-cover cursor-pointer"
                    src="{{ asset('storage/' . $authUser->gambar) }}" alt="">
            @else
                <img class="rounded-full w-full h-full object-cover cursor-pointer" src="{{ asset('img/default_pp.png') }}"
                    alt="">
            @endif


            <div
                class="text-sm absolute right-0 bg-white border rounded shadow-md mt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-20">
                <a href="{{ url('../profile') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                <a href="{{ route('logout') }}" class="text-red-600 block px-4 py-2 hover:bg-gray-100">Logout</a>
            </div>
        </div>
        @endauth
    </div>
</header>
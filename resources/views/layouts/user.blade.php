<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IEA=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    
</head>
 
<body style="background-color: #FEFAE0;">
    <div id="preloder">
        <div class="loader"></div>
    </div>

<div>
    <header class="header-section">
        <div class="container-fluid mt-3">
            <div class="inner-header">
                <div class="logo ml-5">
                    <a href=""><img src="../img/VINTHRI.png" width=150 height=150 alt=""></a>
                </div>
            <div class="flex items-center justify-center">
            <!-- Main Menu -->
            <nav class="main-menu mobile-menu">
                <ul class="flex justify-center">
                    <li><a class="active" href="{{ url('/home') }}" style="color: #5F6F52;">Home</a></li>
                    <li><a href="#" style="color: #5F6F52;">Shop</a>
                    </li>
                    <li><a href="#" style="color: #5F6F52;">Reviews</a></li>
                    <li><a href="#" style="color: #5F6F52;">About</a></li>
                </ul>
    </nav>

    <!-- User Access and Icons -->
    @if (Route::has('login'))
        @auth
            <div class="header-right ml-10 flex">
                <div x-data="{showSearch: false}">
                    <!-- Search Icon -->
                    <img src="../img/icons/search.png" alt="" class="search-trigger" style="margin-right: 5px;" @click="showSearch = !showSearch">
                    <div x-show="showSearch" @click.away="showSearch = false" class="left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                        <form action="{{ route('product.search') }}" method="GET">
                            <input type="text" name="query" placeholder="Search products..." class="block w-full px-4 py-2 text-gray-900 placeholder-gray-500 focus:outline-none" />
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">Search</button>
                        </form>
                    </div>
                </div>
                <!-- Cart Icon -->
                <a href="{{route('cart.display')}}" class="relative ml-2">
                    <img src="../img/icons/bag.png" alt="">
                    <!-- <span>2</span> -->
                </a>
                <!-- User Icon -->
                <div x-data="{show: false}" x-on:click.away="show = false" class="ml-2 relative">
                    <img src="../img/icons/man.png" alt="" class="" id="user-menu-button" aria-expanded="false" aria-haspopup="true" @click="show = !show">
                    <!-- User Menu -->
                    <div x-show="show" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                        <a href="" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Profile</a>
                        <a href="{{ route('orderCustomer.index') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Orders</a>
                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
                    </div>
                </div>
            </div>
        @else
            <!-- User access links for non-authenticated user -->
            <div class="user-access">
                <a href="{{ route('register') }}">Register</a>
                <a href="{{ route('login') }}" class="in">Sign in</a>
            </div>
        @endauth
    @endif
</div>

    </header>
        <main>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <div>@yield('contents')</div>
            </div>
        </main>
    </div>
 
    <script>
        document.getElementById('cartButton').addEventListener('click', function() {
        window.location.href = '{{ url('/cart/display') }}';
        });
    </script>
</body>
 
</html>
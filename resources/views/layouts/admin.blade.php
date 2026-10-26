<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-zinc-50 text-zinc-900 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Atelier Studio — Aurelia Management')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-full flex flex-col bg-[#FAFAFA] text-zinc-800">

    <!-- Top Studio Bar -->
    <header class="bg-white border-b border-zinc-200 sticky top-0 z-30 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Left: Studio Brand & Breadcrumb -->
                <div class="flex items-center gap-6">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 group">
                        <span class="font-cinzel text-lg tracking-[0.25em] font-bold text-zinc-950 uppercase">AURELIA</span>
                        <span class="text-[10px] uppercase tracking-[0.2em] bg-zinc-900 text-amber-300 font-semibold px-2 py-0.5">STUDIO</span>
                    </a>

                    <!-- Nav Tabs (Desktop) -->
                    <nav class="hidden md:flex items-center space-x-1 text-xs font-semibold text-zinc-600">
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md transition {{ request()->routeIs('admin.dashboard') ? 'bg-zinc-100 text-zinc-950 font-bold' : 'hover:bg-zinc-50 hover:text-zinc-900' }}">
                            <i class="fa-solid fa-chart-line mr-1.5 text-zinc-400"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="px-3 py-2 rounded-md transition {{ request()->routeIs('admin.products*') ? 'bg-zinc-100 text-zinc-950 font-bold' : 'hover:bg-zinc-50 hover:text-zinc-900' }}">
                            <i class="fa-solid fa-shirt mr-1.5 text-zinc-400"></i> Products
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="px-3 py-2 rounded-md transition {{ request()->routeIs('admin.orders*') ? 'bg-zinc-100 text-zinc-950 font-bold' : 'hover:bg-zinc-50 hover:text-zinc-900' }}">
                            <i class="fa-solid fa-bag-shopping mr-1.5 text-zinc-400"></i> Orders
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 rounded-md transition {{ request()->routeIs('admin.categories*') ? 'bg-zinc-100 text-zinc-950 font-bold' : 'hover:bg-zinc-50 hover:text-zinc-900' }}">
                            <i class="fa-solid fa-layer-group mr-1.5 text-zinc-400"></i> Categories
                        </a>
                        <a href="{{ route('admin.customers.index') }}" class="px-3 py-2 rounded-md transition {{ request()->routeIs('admin.customers*') ? 'bg-zinc-100 text-zinc-950 font-bold' : 'hover:bg-zinc-50 hover:text-zinc-900' }}">
                            <i class="fa-solid fa-users mr-1.5 text-zinc-400"></i> Clients
                        </a>
                    </nav>
                </div>

                <!-- Right: Quick Actions, Storefront Link, Admin Profile -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" target="_blank" class="text-xs text-zinc-600 hover:text-zinc-950 transition flex items-center gap-1.5 py-1.5 px-3 rounded border border-zinc-200 bg-white hover:bg-zinc-50">
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        <span class="hidden sm:inline font-medium">View Storefront</span>
                    </a>

                    <!-- User Profile & Sign Out -->
                    <div class="flex items-center gap-3 pl-2 border-l border-zinc-200">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold text-zinc-900 leading-tight">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-amber-700 font-semibold tracking-wider uppercase">Administrator</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 text-zinc-500 hover:text-rose-600 transition" title="Sign out">
                                <i class="fa-solid fa-power-off text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Nav bar -->
        <div class="md:hidden flex overflow-x-auto border-t border-zinc-100 px-4 py-2 text-xs font-semibold gap-2 bg-white">
            <a href="{{ route('admin.dashboard') }}" class="px-2.5 py-1.5 whitespace-nowrap rounded {{ request()->routeIs('admin.dashboard') ? 'bg-zinc-900 text-white' : 'bg-zinc-100 text-zinc-700' }}">Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="px-2.5 py-1.5 whitespace-nowrap rounded {{ request()->routeIs('admin.products*') ? 'bg-zinc-900 text-white' : 'bg-zinc-100 text-zinc-700' }}">Products</a>
            <a href="{{ route('admin.orders.index') }}" class="px-2.5 py-1.5 whitespace-nowrap rounded {{ request()->routeIs('admin.orders*') ? 'bg-zinc-900 text-white' : 'bg-zinc-100 text-zinc-700' }}">Orders</a>
            <a href="{{ route('admin.categories.index') }}" class="px-2.5 py-1.5 whitespace-nowrap rounded {{ request()->routeIs('admin.categories*') ? 'bg-zinc-900 text-white' : 'bg-zinc-100 text-zinc-700' }}">Categories</a>
            <a href="{{ route('admin.customers.index') }}" class="px-2.5 py-1.5 whitespace-nowrap rounded {{ request()->routeIs('admin.customers*') ? 'bg-zinc-900 text-white' : 'bg-zinc-100 text-zinc-700' }}">Clients</a>
        </div>
    </header>

    <!-- Global Toast Alerts -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div id="admin-success" class="bg-white border-l-4 border-emerald-500 shadow-sm p-4 rounded-none flex items-center justify-between mb-4">
                <div class="flex items-center gap-3 text-xs text-zinc-800">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('admin-success').remove()" class="text-zinc-400 hover:text-zinc-700">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div id="admin-error" class="bg-white border-l-4 border-rose-500 shadow-sm p-4 rounded-none flex items-center justify-between mb-4">
                <div class="flex items-center gap-3 text-xs text-zinc-800">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('admin-error').remove()" class="text-zinc-400 hover:text-zinc-700">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-zinc-200 py-4 text-center text-xs text-zinc-400">
        AURELIA ATELIER &bull; Administrative Studio v2.4 &bull; Production Ready
    </footer>

    @stack('scripts')
</body>
</html>

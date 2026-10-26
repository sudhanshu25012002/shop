<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white text-zinc-900 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'AURELIA ATELIER — Contemporary Luxury & Tailored Clothing')</title>
    <meta name="description" content="@yield('meta_description', 'Discover handcrafted cashmere coats, virgin wool blazers, and pure mulberry silk blouses made with master Italian craftsmanship.')">

    <!-- Google Fonts: Playfair Display, Cinzel, Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons for crisp luxury icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-full flex flex-col bg-white text-zinc-800 selection:bg-zinc-900 selection:text-white">

    <!-- Top Announcement Bar -->
    <div class="bg-zinc-950 text-white text-[11px] tracking-[0.2em] uppercase py-2 px-4 text-center font-medium border-b border-zinc-800 flex items-center justify-between">
        <div class="hidden sm:block text-zinc-400 text-[10px]">NEW YORK • MILAN • PARIS</div>
        <div class="mx-auto flex items-center gap-2">
            <span class="inline-block w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
            <span>Complimentary Global Delivery on orders over $150 &nbsp;•&nbsp; Code: <span class="text-amber-300 font-semibold">WELCOME10</span> for 10% off</span>
        </div>
        <div class="hidden sm:flex items-center gap-3 text-[10px] text-zinc-400">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-amber-400 hover:text-white transition flex items-center gap-1 font-semibold">
                        <i class="fa-solid fa-gauge-high"></i> Admin Studio
                    </a>
                @endif
                <span class="text-zinc-600">|</span>
            @endauth
            <a href="{{ route('demo.login', 'admin') }}" class="hover:text-white transition underline underline-offset-2">Demo Admin</a>
            <span>•</span>
            <a href="{{ route('demo.login', 'customer') }}" class="hover:text-white transition underline underline-offset-2">Demo Customer</a>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-zinc-200/80 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Mobile Menu Button -->
                <div class="flex items-center lg:hidden">
                    <button type="button" id="mobile-menu-btn" class="p-2 text-zinc-700 hover:text-zinc-950 focus:outline-none" aria-label="Toggle mobile menu">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <button type="button" onclick="openSearchModal()" class="ml-2 p-2 text-zinc-700 hover:text-zinc-950" aria-label="Search">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </button>
                </div>

                <!-- Desktop Left Navigation -->
                <nav class="hidden lg:flex items-center space-x-8 text-[12px] uppercase tracking-[0.18em] font-medium text-zinc-700">
                    <a href="{{ route('shop.index') }}" class="hover:text-zinc-950 transition duration-150 py-2 border-b-2 {{ request()->routeIs('shop.index') && !request('category') ? 'border-zinc-900 text-zinc-950' : 'border-transparent' }}">
                        All Collections
                    </a>
                    <a href="{{ route('shop.index', ['category' => 'outerwear-coats']) }}" class="hover:text-zinc-950 transition duration-150 py-2 border-b-2 {{ request('category') === 'outerwear-coats' ? 'border-zinc-900 text-zinc-950' : 'border-transparent' }}">
                        Coats
                    </a>
                    <a href="{{ route('shop.index', ['category' => 'tailored-blazers']) }}" class="hover:text-zinc-950 transition duration-150 py-2 border-b-2 {{ request('category') === 'tailored-blazers' ? 'border-zinc-900 text-zinc-950' : 'border-transparent' }}">
                        Blazers
                    </a>
                    <a href="{{ route('shop.index', ['category' => 'silk-tops']) }}" class="hover:text-zinc-950 transition duration-150 py-2 border-b-2 {{ request('category') === 'silk-tops' ? 'border-zinc-900 text-zinc-950' : 'border-transparent' }}">
                        Silk & Tops
                    </a>
                    <a href="{{ route('shop.index', ['category' => 'luxury-knitwear']) }}" class="hover:text-zinc-950 transition duration-150 py-2 border-b-2 {{ request('category') === 'luxury-knitwear' ? 'border-zinc-900 text-zinc-950' : 'border-transparent' }}">
                        Knitwear
                    </a>
                </nav>

                <!-- Centered Luxury Brand Logo -->
                <div class="flex-shrink-0 text-center">
                    <a href="{{ route('home') }}" class="group block py-1">
                        <span class="block font-cinzel text-xl sm:text-2xl md:text-[26px] tracking-[0.32em] font-semibold text-zinc-950 uppercase group-hover:opacity-85 transition">
                            AURELIA
                        </span>
                        <span class="block text-[8px] sm:text-[9px] uppercase tracking-[0.45em] text-zinc-500 font-medium -mt-0.5">
                            ATELIER • NEW YORK
                        </span>
                    </a>
                </div>

                <!-- Right Utilities: Search, Account, Wishlist, Bag -->
                <div class="flex items-center space-x-3 sm:space-x-6 text-zinc-800">
                    <!-- Search Trigger (Desktop) -->
                    <button type="button" onclick="openSearchModal()" class="hidden sm:flex items-center gap-2 text-[12px] uppercase tracking-wider text-zinc-500 hover:text-zinc-950 transition" title="Search catalog">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        <span class="hidden md:inline font-medium">Search</span>
                    </button>

                    <!-- User Account / Sign In -->
                    <div class="relative group">
                        @auth
                            <div class="flex items-center gap-2 cursor-pointer py-2">
                                <span class="w-8 h-8 rounded-full bg-zinc-100 border border-zinc-200 flex items-center justify-center text-xs font-semibold text-zinc-800">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                                <span class="hidden xl:inline text-xs font-medium text-zinc-700 max-w-[100px] truncate">
                                    {{ auth()->user()->name }}
                                </span>
                                <i class="fa-solid fa-chevron-down text-[10px] text-zinc-400 group-hover:rotate-180 transition-transform"></i>
                            </div>
                            <!-- Dropdown -->
                            <div class="absolute right-0 mt-1 w-56 bg-white border border-zinc-200 shadow-xl rounded-none py-2 hidden group-hover:block z-50 animate-fadeIn">
                                <div class="px-4 py-2 border-b border-zinc-100">
                                    <p class="text-xs font-semibold text-zinc-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-[11px] text-zinc-500 truncate">{{ auth()->user()->email }}</p>
                                    <span class="inline-block mt-1 text-[9px] uppercase font-bold tracking-wider px-2 py-0.5 rounded {{ auth()->user()->isAdmin() ? 'bg-amber-100 text-amber-900' : 'bg-zinc-100 text-zinc-800' }}">
                                        {{ ucfirst(auth()->user()->role) }}
                                    </span>
                                </div>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-xs text-amber-900 hover:bg-amber-50 font-semibold">
                                        <i class="fa-solid fa-gauge-high mr-2 text-amber-600"></i> Admin Studio
                                    </a>
                                @endif
                                <a href="{{ route('orders.track') }}" class="block px-4 py-2 text-xs text-zinc-700 hover:bg-zinc-50">
                                    <i class="fa-solid fa-box-open mr-2 text-zinc-400"></i> Track Orders
                                </a>
                                <div class="border-t border-zinc-100 my-1"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-xs text-rose-700 hover:bg-rose-50 flex items-center">
                                        <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Sign Out
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-[12px] uppercase tracking-wider text-zinc-600 hover:text-zinc-950 transition flex items-center gap-1.5" title="Sign In">
                                <i class="fa-regular fa-user text-sm"></i>
                                <span class="hidden md:inline font-medium">Sign In</span>
                            </a>
                        @endauth
                    </div>

                    <!-- Shopping Bag Trigger -->
                    @php
                        $cart = session()->get('cart', []);
                        $cartCount = array_sum(array_column($cart, 'quantity'));
                    @endphp
                    <button type="button" onclick="openCartDrawer()" class="relative p-2 text-zinc-800 hover:text-zinc-950 transition flex items-center gap-1.5" aria-label="Shopping Bag">
                        <i class="fa-solid fa-bag-shopping text-base"></i>
                        <span id="header-bag-count" class="inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[10px] font-bold text-white bg-zinc-950 rounded-full {{ $cartCount > 0 ? '' : 'hidden' }}">
                            {{ $cartCount }}
                        </span>
                        <span class="hidden md:inline text-[12px] uppercase tracking-wider font-medium text-zinc-700">Bag</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Slide-Down Drawer -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-zinc-200 bg-white px-4 pt-3 pb-6 space-y-3">
            <div class="space-y-1 text-xs uppercase tracking-wider font-semibold text-zinc-800">
                <a href="{{ route('shop.index') }}" class="block py-2.5 border-b border-zinc-100">All Collections</a>
                <a href="{{ route('shop.index', ['category' => 'outerwear-coats']) }}" class="block py-2.5 border-b border-zinc-100">Outerwear & Coats</a>
                <a href="{{ route('shop.index', ['category' => 'tailored-blazers']) }}" class="block py-2.5 border-b border-zinc-100">Tailored Blazers</a>
                <a href="{{ route('shop.index', ['category' => 'silk-tops']) }}" class="block py-2.5 border-b border-zinc-100">Silk & Blouses</a>
                <a href="{{ route('shop.index', ['category' => 'trousers-tailoring']) }}" class="block py-2.5 border-b border-zinc-100">Pleated Trousers</a>
                <a href="{{ route('shop.index', ['category' => 'luxury-knitwear']) }}" class="block py-2.5 border-b border-zinc-100">Luxury Knitwear</a>
                <a href="{{ route('shop.index', ['category' => 'dresses-evening']) }}" class="block py-2.5 border-b border-zinc-100">Evening Dresses</a>
                <a href="{{ route('shop.index', ['category' => 'leather-bags']) }}" class="block py-2.5 border-b border-zinc-100">Leather & Handbags</a>
            </div>
            <div class="pt-2 flex flex-col gap-2">
                <a href="{{ route('orders.track') }}" class="text-xs text-zinc-600 hover:text-zinc-900 py-1 flex items-center gap-2">
                    <i class="fa-solid fa-truck-fast text-zinc-400"></i> Track An Order
                </a>
                <div class="flex items-center gap-3 pt-2 text-[11px] text-zinc-500">
                    <a href="{{ route('demo.login', 'admin') }}" class="px-2.5 py-1 bg-zinc-100 rounded text-zinc-800">Switch to Admin</a>
                    <a href="{{ route('demo.login', 'customer') }}" class="px-2.5 py-1 bg-zinc-100 rounded text-zinc-800">Switch to Customer</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Global Toast Alerts / Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div id="flash-success" class="bg-zinc-950 text-white px-5 py-3.5 rounded-none flex items-center justify-between shadow-lg border-l-4 border-emerald-400 transition-all">
                <div class="flex items-center gap-3 text-sm">
                    <i class="fa-solid fa-circle-check text-emerald-400 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('flash-success').remove()" class="text-zinc-400 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div id="flash-error" class="bg-rose-950 text-white px-5 py-3.5 rounded-none flex items-center justify-between shadow-lg border-l-4 border-rose-400 transition-all">
                <div class="flex items-center gap-3 text-sm">
                    <i class="fa-solid fa-triangle-exclamation text-rose-400 text-base"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('flash-error').remove()" class="text-rose-200 hover:text-white">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('info'))
            <div id="flash-info" class="bg-zinc-100 text-zinc-900 border border-zinc-300 px-5 py-3.5 rounded-none flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3 text-sm">
                    <i class="fa-solid fa-circle-info text-zinc-500 text-base"></i>
                    <span>{{ session('info') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('flash-info').remove()" class="text-zinc-500 hover:text-zinc-900">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Brand Ethos & Guarantees -->
    <section class="border-t border-zinc-200 bg-zinc-50/70 py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center md:text-left">
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-full bg-white border border-zinc-200 flex items-center justify-center mx-auto md:mx-0 text-zinc-900">
                        <i class="fa-solid fa-feather text-sm"></i>
                    </div>
                    <h4 class="text-xs uppercase tracking-[0.16em] font-bold text-zinc-900">100% Pure Natural Fibers</h4>
                    <p class="text-xs text-zinc-500 leading-relaxed">Mongolian grade-A cashmere, 22mm mulberry silk, and Super 130s Italian virgin wool.</p>
                </div>
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-full bg-white border border-zinc-200 flex items-center justify-center mx-auto md:mx-0 text-zinc-900">
                        <i class="fa-solid fa-box-open text-sm"></i>
                    </div>
                    <h4 class="text-xs uppercase tracking-[0.16em] font-bold text-zinc-900">Complimentary Global Delivery</h4>
                    <p class="text-xs text-zinc-500 leading-relaxed">Complimentary insured express delivery on all orders over $150 with discreet bespoke packaging.</p>
                </div>
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-full bg-white border border-zinc-200 flex items-center justify-center mx-auto md:mx-0 text-zinc-900">
                        <i class="fa-solid fa-arrows-rotate text-sm"></i>
                    </div>
                    <h4 class="text-xs uppercase tracking-[0.16em] font-bold text-zinc-900">Atelier Guarantee & Returns</h4>
                    <p class="text-xs text-zinc-500 leading-relaxed">30-day effortless complimentary returns and lifetime button and seam maintenance.</p>
                </div>
                <div class="space-y-2">
                    <div class="w-10 h-10 rounded-full bg-white border border-zinc-200 flex items-center justify-center mx-auto md:mx-0 text-zinc-900">
                        <i class="fa-solid fa-hand-sparkles text-sm"></i>
                    </div>
                    <h4 class="text-xs uppercase tracking-[0.16em] font-bold text-zinc-900">Tuscan Craftsmanship</h4>
                    <p class="text-xs text-zinc-500 leading-relaxed">Hand-cut and finished by generational multi-decade artisans in Florence and Biella, Italy.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Luxury Footer -->
    <footer class="bg-zinc-950 text-white pt-16 pb-12 border-t border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-10 pb-14 border-b border-zinc-800/80">
                <!-- Brand Column -->
                <div class="md:col-span-2 space-y-4">
                    <h3 class="font-cinzel text-xl tracking-[0.28em] font-bold text-white uppercase">AURELIA</h3>
                    <p class="text-xs text-zinc-400 max-w-sm leading-relaxed">
                        An architectural exploration of quiet luxury. We craft monochromatic modern garments designed for longevity, understated presence, and supreme tactile comfort.
                    </p>
                    <div class="pt-2">
                        <p class="text-[11px] uppercase tracking-wider text-zinc-400 font-semibold mb-2">Join the Atelier Gazette</p>
                        <form onsubmit="handleNewsletter(event)" class="flex max-w-md">
                            <input type="email" required placeholder="Enter your email address" class="bg-zinc-900 border border-zinc-700 text-white placeholder-zinc-500 px-4 py-2.5 text-xs w-full focus:outline-none focus:border-amber-400 transition">
                            <button type="submit" class="bg-white text-zinc-950 px-5 py-2.5 text-xs uppercase tracking-wider font-semibold hover:bg-zinc-200 transition">Subscribe</button>
                        </form>
                        <p id="newsletter-feedback" class="text-[11px] text-emerald-400 mt-2 hidden">Thank you. You have been added to our private collection previews.</p>
                    </div>
                </div>

                <!-- Collections -->
                <div>
                    <h4 class="text-xs uppercase tracking-[0.2em] font-semibold text-zinc-200 mb-4">Collections</h4>
                    <ul class="space-y-2.5 text-xs text-zinc-400">
                        <li><a href="{{ route('shop.index', ['category' => 'outerwear-coats']) }}" class="hover:text-white transition">Cashmere Overcoats</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'tailored-blazers']) }}" class="hover:text-white transition">Wool Blazers</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'silk-tops']) }}" class="hover:text-white transition">Mulberry Silk</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'trousers-tailoring']) }}" class="hover:text-white transition">Wide Pleat Trousers</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'luxury-knitwear']) }}" class="hover:text-white transition">Heirloom Knitwear</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'dresses-evening']) }}" class="hover:text-white transition">Silk Slip Dresses</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'leather-bags']) }}" class="hover:text-white transition">Tuscan Leather Bags</a></li>
                    </ul>
                </div>

                <!-- Client Service -->
                <div>
                    <h4 class="text-xs uppercase tracking-[0.2em] font-semibold text-zinc-200 mb-4">Client Service</h4>
                    <ul class="space-y-2.5 text-xs text-zinc-400">
                        <li><a href="{{ route('orders.track') }}" class="hover:text-white transition">Track Your Order</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-white transition">Shopping Bag</a></li>
                        <li><a href="{{ route('checkout.index') }}" class="hover:text-white transition">Express Checkout</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Client Account</a></li>
                        <li><a href="#size-guide" onclick="openSizeGuideModal()" class="hover:text-white transition">Atelier Size Guide</a></li>
                        <li><a href="mailto:concierge@aurelia.com" class="hover:text-white transition">Private Concierge</a></li>
                    </ul>
                </div>

                <!-- Ateliers & Boutiques -->
                <div>
                    <h4 class="text-xs uppercase tracking-[0.2em] font-semibold text-zinc-200 mb-4">Ateliers</h4>
                    <ul class="space-y-2 text-xs text-zinc-400">
                        <li class="font-medium text-zinc-300">Flagship Boutique</li>
                        <li>740 Madison Avenue</li>
                        <li>New York, NY 10065</li>
                        <li class="pt-2 font-medium text-zinc-300">Milano Showroom</li>
                        <li>Via Monte Napoleone 8</li>
                        <li>20121 Milano, Italy</li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-zinc-500 gap-4">
                <p>&copy; {{ date('Y') }} AURELIA ATELIER INC. All rights reserved. Masterfully crafted with Laravel & Tailwind.</p>
                <div class="flex items-center gap-6">
                    <span class="hover:text-zinc-400 cursor-pointer">Privacy Policy</span>
                    <span class="hover:text-zinc-400 cursor-pointer">Terms of Service</span>
                    <span class="hover:text-zinc-400 cursor-pointer">Sustainability Report</span>
                    <a href="{{ route('admin.dashboard') }}" class="text-amber-400/80 hover:text-amber-300 font-medium">Admin Studio</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- SLIDING CART DRAWER (RIGHT) -->
    <div id="cart-drawer" class="fixed inset-0 z-50 overflow-hidden hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div id="cart-drawer-backdrop" onclick="closeCartDrawer()" class="absolute inset-0 bg-zinc-950/60 backdrop-blur-sm transition-opacity opacity-0 duration-300"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div id="cart-drawer-panel" class="w-screen max-w-md bg-white shadow-2xl flex flex-col transform translate-x-full transition-transform duration-300 ease-in-out">
                <!-- Drawer Header -->
                <div class="p-6 border-b border-zinc-200 flex items-center justify-between bg-zinc-50/50">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-bag-shopping text-zinc-800"></i>
                        <h2 class="text-sm uppercase tracking-[0.18em] font-bold text-zinc-900" id="slide-over-title">Your Atelier Bag</h2>
                        <span id="drawer-item-count" class="text-xs bg-zinc-200 text-zinc-700 px-2 py-0.5 rounded-full font-semibold">0</span>
                    </div>
                    <button type="button" onclick="closeCartDrawer()" class="text-zinc-400 hover:text-zinc-900 p-1">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Free Shipping Progress Bar -->
                <div class="px-6 py-3.5 bg-amber-50/60 border-b border-amber-100 text-xs">
                    <div class="flex items-center justify-between font-medium text-amber-900 mb-1.5" id="shipping-progress-text">
                        <span>Complimentary Shipping</span>
                        <span id="shipping-progress-status">$150.00 needed</span>
                    </div>
                    <div class="w-full bg-amber-200/60 rounded-full h-1.5 overflow-hidden">
                        <div id="shipping-progress-bar" class="bg-amber-600 h-1.5 rounded-full transition-all duration-500" style="width: 0%"></div>
                    </div>
                </div>

                <!-- Cart Items List -->
                <div id="drawer-items-container" class="flex-1 overflow-y-auto p-6 space-y-4">
                    <div class="text-center py-12 text-zinc-400" id="drawer-empty-state">
                        <i class="fa-regular fa-bag-shopping text-4xl mb-3 text-zinc-300"></i>
                        <p class="text-sm font-medium text-zinc-600">Your bag is currently empty.</p>
                        <p class="text-xs text-zinc-400 mt-1">Explore our latest seasonal arrivals.</p>
                        <a href="{{ route('shop.index') }}" onclick="closeCartDrawer()" class="mt-4 inline-block px-5 py-2.5 bg-zinc-900 text-white text-xs uppercase tracking-wider font-semibold hover:bg-zinc-800 transition">
                            Explore Catalog
                        </a>
                    </div>
                </div>

                <!-- Drawer Footer -->
                <div id="drawer-footer" class="p-6 border-t border-zinc-200 bg-zinc-50/70 space-y-4">
                    <div class="flex justify-between items-center text-sm font-medium">
                        <span class="text-zinc-600 uppercase tracking-wider text-xs">Subtotal</span>
                        <span id="drawer-subtotal" class="font-cinzel text-lg font-bold text-zinc-950">$0.00</span>
                    </div>
                    <p class="text-[11px] text-zinc-500">Taxes and shipping calculated during checkout.</p>
                    <div class="grid grid-cols-2 gap-3 pt-1">
                        <a href="{{ route('cart.index') }}" class="text-center py-3 px-4 border border-zinc-300 text-zinc-800 text-xs uppercase tracking-wider font-semibold hover:bg-zinc-100 transition">
                            View Bag
                        </a>
                        <a href="{{ route('checkout.index') }}" class="text-center py-3 px-4 bg-zinc-950 text-white text-xs uppercase tracking-wider font-semibold hover:bg-zinc-800 transition shadow-md">
                            Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QUICK VIEW MODAL -->
    <div id="quick-view-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div id="quick-view-backdrop" onclick="closeQuickViewModal()" class="fixed inset-0 bg-zinc-950/70 backdrop-blur-sm transition-opacity opacity-0 duration-300"></div>

            <div id="quick-view-panel" class="relative inline-block align-bottom bg-white text-left overflow-hidden shadow-2xl transform opacity-0 translate-y-4 sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full transition-all duration-300 border border-zinc-200">
                <button type="button" onclick="closeQuickViewModal()" class="absolute top-4 right-4 text-zinc-400 hover:text-zinc-900 z-10 p-2">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>

                <div class="grid grid-cols-1 md:grid-cols-2">
                    <!-- Image -->
                    <div class="bg-zinc-100 aspect-3/4 overflow-hidden flex items-center justify-center">
                        <img id="qv-image" src="" alt="Product" class="w-full h-full object-cover">
                    </div>
                    <!-- Details -->
                    <div class="p-6 md:p-8 flex flex-col justify-between">
                        <div>
                            <span id="qv-category" class="text-[10px] uppercase tracking-[0.2em] text-zinc-500 font-semibold block mb-1">CATEGORY</span>
                            <h3 id="qv-name" class="font-serif-luxury text-2xl text-zinc-900 mb-2 font-medium">Product Name</h3>
                            <p id="qv-tagline" class="text-xs text-amber-900/80 italic mb-4">Tagline</p>
                            
                            <div class="flex items-baseline gap-3 mb-4">
                                <span id="qv-price" class="font-cinzel text-2xl font-bold text-zinc-950">$0.00</span>
                                <span id="qv-compare-price" class="text-sm text-zinc-400 line-through"></span>
                                <span id="qv-discount" class="text-[11px] bg-rose-50 text-rose-700 font-bold px-2 py-0.5 border border-rose-200"></span>
                            </div>

                            <p id="qv-description" class="text-xs text-zinc-600 leading-relaxed mb-6 line-clamp-3">Description</p>

                            <!-- Sizes -->
                            <div class="mb-4">
                                <div class="flex justify-between items-center text-xs mb-2">
                                    <span class="uppercase tracking-wider font-semibold text-zinc-800">Select Size</span>
                                    <button type="button" onclick="openSizeGuideModal()" class="text-zinc-500 underline text-[11px]">Size Guide</button>
                                </div>
                                <div id="qv-sizes-container" class="flex flex-wrap gap-2"></div>
                            </div>

                            <!-- Colors -->
                            <div class="mb-6">
                                <span class="text-xs uppercase tracking-wider font-semibold text-zinc-800 block mb-2">Available Shade</span>
                                <div id="qv-colors-container" class="flex flex-wrap gap-2"></div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-3 pt-4 border-t border-zinc-100">
                            <button type="button" id="qv-add-btn" onclick="addToCartFromQuickView()" class="w-full py-3.5 bg-zinc-950 text-white text-xs uppercase tracking-[0.16em] font-bold hover:bg-zinc-800 transition shadow-md flex items-center justify-center gap-2">
                                <i class="fa-solid fa-bag-shopping"></i> Add to Bag
                            </button>
                            <a id="qv-view-full" href="#" class="block text-center text-xs uppercase tracking-wider font-semibold text-zinc-700 hover:text-zinc-950 py-1 underline underline-offset-4">
                                View Full Product Details & Materials &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SEARCH MODAL -->
    <div id="search-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" role="dialog" aria-modal="true">
        <div class="min-h-screen px-4 text-center">
            <div onclick="closeSearchModal()" class="fixed inset-0 bg-zinc-950/70 backdrop-blur-sm transition-opacity"></div>
            <div class="inline-block w-full max-w-2xl my-20 p-6 bg-white shadow-2xl text-left border border-zinc-200 relative z-10 animate-fadeIn">
                <div class="flex items-center justify-between pb-4 border-b border-zinc-200">
                    <span class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-900">Search Atelier Catalog</span>
                    <button type="button" onclick="closeSearchModal()" class="text-zinc-400 hover:text-zinc-900">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
                <form action="{{ route('shop.index') }}" method="GET" class="mt-4">
                    <div class="relative">
                        <input type="text" name="q" autofocus placeholder="Search cashmere coats, silk shirts, blazers..." class="w-full pl-10 pr-4 py-3.5 border-b-2 border-zinc-900 text-base placeholder-zinc-400 focus:outline-none">
                        <i class="fa-solid fa-magnifying-glass absolute left-2 top-4 text-zinc-400"></i>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2 text-xs">
                        <span class="text-zinc-400 py-1">Popular searches:</span>
                        <a href="{{ route('shop.index', ['q' => 'cashmere']) }}" class="px-2.5 py-1 bg-zinc-100 hover:bg-zinc-200 text-zinc-800 rounded">Cashmere</a>
                        <a href="{{ route('shop.index', ['q' => 'silk']) }}" class="px-2.5 py-1 bg-zinc-100 hover:bg-zinc-200 text-zinc-800 rounded">Mulberry Silk</a>
                        <a href="{{ route('shop.index', ['q' => 'blazer']) }}" class="px-2.5 py-1 bg-zinc-100 hover:bg-zinc-200 text-zinc-800 rounded">Tailored Blazer</a>
                        <a href="{{ route('shop.index', ['q' => 'trousers']) }}" class="px-2.5 py-1 bg-zinc-100 hover:bg-zinc-200 text-zinc-800 rounded">Pleated Trousers</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SIZE GUIDE MODAL -->
    <div id="size-guide-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 text-center">
            <div onclick="closeSizeGuideModal()" class="fixed inset-0 bg-zinc-950/70 backdrop-blur-sm"></div>
            <div class="inline-block w-full max-w-xl my-8 p-6 bg-white shadow-2xl text-left border border-zinc-200 relative z-10">
                <div class="flex items-center justify-between pb-3 border-b border-zinc-200">
                    <h3 class="font-cinzel text-lg font-bold text-zinc-950 uppercase">Atelier Sizing Standard</h3>
                    <button type="button" onclick="closeSizeGuideModal()" class="text-zinc-400 hover:text-zinc-900">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
                <div class="mt-4 overflow-x-auto text-xs">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-zinc-300 text-zinc-500 uppercase tracking-wider text-[11px]">
                                <th class="py-2">Size</th>
                                <th class="py-2">US</th>
                                <th class="py-2">UK</th>
                                <th class="py-2">IT</th>
                                <th class="py-2">Bust (in)</th>
                                <th class="py-2">Waist (in)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 text-zinc-700">
                            <tr><td class="py-2 font-bold text-zinc-900">XS</td><td>0-2</td><td>4-6</td><td>36-38</td><td>32-33</td><td>24-25</td></tr>
                            <tr><td class="py-2 font-bold text-zinc-900">S</td><td>4-6</td><td>8-10</td><td>40-42</td><td>34-35</td><td>26-27</td></tr>
                            <tr><td class="py-2 font-bold text-zinc-900">M</td><td>8-10</td><td>12-14</td><td>44-46</td><td>36-37</td><td>28-29</td></tr>
                            <tr><td class="py-2 font-bold text-zinc-900">L</td><td>12-14</td><td>16-18</td><td>48-50</td><td>38-40</td><td>30-32</td></tr>
                            <tr><td class="py-2 font-bold text-zinc-900">XL</td><td>16</td><td>20</td><td>52</td><td>41-43</td><td>33-35</td></tr>
                        </tbody>
                    </table>
                </div>
                <p class="text-[11px] text-zinc-500 mt-4 leading-relaxed">
                    All our tailoring is patterned true-to-size with a contemporary relaxed drape. For assistance with customized bespoke fitting, contact our private concierge.
                </p>
            </div>
        </div>
    </div>

    <!-- GLOBAL JAVASCRIPT FOR CART DRAWER, QUICK VIEW & INTERACTION -->
    <script>
        let currentQuickViewProduct = null;
        let selectedQuickViewSize = null;
        let selectedQuickViewColor = null;

        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Search modal
        function openSearchModal() {
            document.getElementById('search-modal').classList.remove('hidden');
            setTimeout(() => document.querySelector('#search-modal input')?.focus(), 100);
        }
        function closeSearchModal() {
            document.getElementById('search-modal').classList.add('hidden');
        }

        // Size guide modal
        function openSizeGuideModal() {
            document.getElementById('size-guide-modal').classList.remove('hidden');
        }
        function closeSizeGuideModal() {
            document.getElementById('size-guide-modal').classList.add('hidden');
        }

        // Cart Drawer
        function openCartDrawer() {
            const drawer = document.getElementById('cart-drawer');
            const backdrop = document.getElementById('cart-drawer-backdrop');
            const panel = document.getElementById('cart-drawer-panel');

            drawer.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');
                panel.classList.remove('translate-x-full');
            }, 10);

            refreshCartSummary();
        }

        function closeCartDrawer() {
            const backdrop = document.getElementById('cart-drawer-backdrop');
            const panel = document.getElementById('cart-drawer-panel');

            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            panel.classList.add('translate-x-full');

            setTimeout(() => {
                document.getElementById('cart-drawer').classList.add('hidden');
            }, 300);
        }

        // Fetch cart summary & render in drawer
        async function refreshCartSummary() {
            try {
                const res = await fetch('{{ route('cart.summary') }}');
                const data = await res.json();

                // Update badge in header
                const countBadge = document.getElementById('header-bag-count');
                if (countBadge) {
                    countBadge.textContent = data.count;
                    if (data.count > 0) {
                        countBadge.classList.remove('hidden');
                    } else {
                        countBadge.classList.add('hidden');
                    }
                }

                // Update drawer item count
                const drawerCount = document.getElementById('drawer-item-count');
                if (drawerCount) drawerCount.textContent = data.count;

                // Update subtotal
                const subtotalEl = document.getElementById('drawer-subtotal');
                if (subtotalEl) subtotalEl.textContent = '$' + data.subtotal;

                // Update shipping progress
                const progressBar = document.getElementById('shipping-progress-bar');
                const progressStatus = document.getElementById('shipping-progress-status');
                if (progressBar) progressBar.style.width = data.shippingProgress + '%';
                if (progressStatus) {
                    if (data.freeShipping) {
                        progressStatus.textContent = 'Unlocked!';
                        progressStatus.classList.add('text-emerald-700');
                    } else {
                        progressStatus.textContent = '$' + data.shippingNeeded + ' to unlock';
                        progressStatus.classList.remove('text-emerald-700');
                    }
                }

                // Render items
                const container = document.getElementById('drawer-items-container');
                const footer = document.getElementById('drawer-footer');

                if (data.items.length === 0) {
                    container.innerHTML = `
                        <div class="text-center py-12 text-zinc-400">
                            <i class="fa-regular fa-bag-shopping text-4xl mb-3 text-zinc-300"></i>
                            <p class="text-sm font-medium text-zinc-600">Your bag is currently empty.</p>
                            <p class="text-xs text-zinc-400 mt-1">Explore our latest seasonal arrivals.</p>
                            <a href="{{ route('shop.index') }}" onclick="closeCartDrawer()" class="mt-4 inline-block px-5 py-2.5 bg-zinc-900 text-white text-xs uppercase tracking-wider font-semibold hover:bg-zinc-800 transition">
                                Explore Catalog
                            </a>
                        </div>
                    `;
                    if (footer) footer.classList.add('opacity-50', 'pointer-events-none');
                } else {
                    if (footer) footer.classList.remove('opacity-50', 'pointer-events-none');
                    let html = '';
                    data.items.forEach(item => {
                        html += `
                            <div class="flex gap-4 pb-4 border-b border-zinc-100 items-start">
                                <img src="${item.image}" alt="${item.name}" class="w-18 h-24 object-cover bg-zinc-100 flex-shrink-0 border border-zinc-200">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-xs font-semibold text-zinc-900 truncate">${item.name}</h4>
                                    <p class="text-[11px] text-zinc-500 mt-0.5">Size: <span class="font-medium text-zinc-800">${item.size}</span> • Shade: <span class="font-medium text-zinc-800">${item.color}</span></p>
                                    <p class="font-cinzel text-xs font-bold text-zinc-950 mt-1.5">$${parseFloat(item.price).toFixed(2)}</p>
                                    <div class="flex items-center justify-between mt-3">
                                        <div class="flex items-center border border-zinc-300">
                                            <button onclick="updateCartItem('${item.key}', ${item.quantity - 1})" class="px-2 py-0.5 text-xs text-zinc-600 hover:bg-zinc-100">-</button>
                                            <span class="px-2 py-0.5 text-xs font-semibold text-zinc-900">${item.quantity}</span>
                                            <button onclick="updateCartItem('${item.key}', ${item.quantity + 1})" class="px-2 py-0.5 text-xs text-zinc-600 hover:bg-zinc-100">+</button>
                                        </div>
                                        <button onclick="removeCartItem('${item.key}')" class="text-[11px] text-zinc-400 hover:text-rose-600 transition">
                                            <i class="fa-regular fa-trash-can"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    container.innerHTML = html;
                }
            } catch (err) {
                console.error('Error refreshing cart:', err);
            }
        }

        // Add to cart via AJAX
        async function addToCartAjax(productId, size = null, color = null, quantity = 1) {
            try {
                const res = await fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ product_id: productId, size, color, quantity })
                });
                const data = await res.json();
                if (data.success) {
                    openCartDrawer();
                }
            } catch (err) {
                console.error('Cart add failed:', err);
            }
        }

        // Update quantity
        async function updateCartItem(key, quantity) {
            if (quantity <= 0) {
                removeCartItem(key);
                return;
            }
            try {
                await fetch('{{ route('cart.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ key, quantity })
                });
                refreshCartSummary();
            } catch (err) {
                console.error(err);
            }
        }

        // Remove item
        async function removeCartItem(key) {
            try {
                await fetch('{{ route('cart.remove') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ key })
                });
                refreshCartSummary();
            } catch (err) {
                console.error(err);
            }
        }

        // Quick View Modal
        async function openQuickView(productId) {
            try {
                const res = await fetch(`/api/quick-view/${productId}`);
                const product = await res.json();
                currentQuickViewProduct = product;

                document.getElementById('qv-image').src = product.image;
                document.getElementById('qv-category').textContent = product.category;
                document.getElementById('qv-name').textContent = product.name;
                document.getElementById('qv-tagline').textContent = product.tagline || '';
                document.getElementById('qv-price').textContent = '$' + product.price;
                document.getElementById('qv-description').textContent = product.description;
                document.getElementById('qv-view-full').href = product.url;

                const compareEl = document.getElementById('qv-compare-price');
                const discEl = document.getElementById('qv-discount');
                if (product.compare_at_price) {
                    compareEl.textContent = '$' + product.compare_at_price;
                    discEl.textContent = '-' + product.discount + '%';
                    compareEl.classList.remove('hidden');
                    discEl.classList.remove('hidden');
                } else {
                    compareEl.classList.add('hidden');
                    discEl.classList.add('hidden');
                }

                // Render Sizes
                const sizesContainer = document.getElementById('qv-sizes-container');
                sizesContainer.innerHTML = '';
                selectedQuickViewSize = product.sizes[0] || 'M';
                product.sizes.forEach((s, idx) => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = `px-3 py-1.5 text-xs border font-medium transition ${idx === 0 ? 'border-zinc-950 bg-zinc-950 text-white' : 'border-zinc-300 text-zinc-800 hover:border-zinc-900'}`;
                    btn.textContent = s;
                    btn.onclick = () => {
                        sizesContainer.querySelectorAll('button').forEach(b => {
                            b.className = 'px-3 py-1.5 text-xs border font-medium transition border-zinc-300 text-zinc-800 hover:border-zinc-900';
                        });
                        btn.className = 'px-3 py-1.5 text-xs border font-medium transition border-zinc-950 bg-zinc-950 text-white';
                        selectedQuickViewSize = s;
                    };
                    sizesContainer.appendChild(btn);
                });

                // Render Colors
                const colorsContainer = document.getElementById('qv-colors-container');
                colorsContainer.innerHTML = '';
                selectedQuickViewColor = product.colors[0]?.name || 'White';
                product.colors.forEach((c, idx) => {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = `px-3 py-1 text-xs border flex items-center gap-1.5 transition ${idx === 0 ? 'border-zinc-900 bg-zinc-100 font-bold' : 'border-zinc-200 text-zinc-600'}`;
                    btn.innerHTML = `<span class="w-2.5 h-2.5 rounded-full border border-zinc-300 inline-block" style="background-color: ${c.hex}"></span> <span>${c.name}</span>`;
                    btn.onclick = () => {
                        colorsContainer.querySelectorAll('button').forEach(b => {
                            b.className = 'px-3 py-1 text-xs border flex items-center gap-1.5 transition border-zinc-200 text-zinc-600';
                        });
                        btn.className = 'px-3 py-1 text-xs border flex items-center gap-1.5 transition border-zinc-900 bg-zinc-100 font-bold';
                        selectedQuickViewColor = c.name;
                    };
                    colorsContainer.appendChild(btn);
                });

                // Open modal
                const modal = document.getElementById('quick-view-modal');
                const backdrop = document.getElementById('quick-view-backdrop');
                const panel = document.getElementById('quick-view-panel');

                modal.classList.remove('hidden');
                setTimeout(() => {
                    backdrop.classList.remove('opacity-0');
                    backdrop.classList.add('opacity-100');
                    panel.classList.remove('opacity-0', 'translate-y-4');
                    panel.classList.add('opacity-100', 'translate-y-0');
                }, 10);

            } catch (err) {
                console.error(err);
            }
        }

        function closeQuickViewModal() {
            const backdrop = document.getElementById('quick-view-backdrop');
            const panel = document.getElementById('quick-view-panel');

            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'translate-y-0');
            panel.classList.add('opacity-0', 'translate-y-4');

            setTimeout(() => {
                document.getElementById('quick-view-modal').classList.add('hidden');
            }, 300);
        }

        function addToCartFromQuickView() {
            if (!currentQuickViewProduct) return;
            addToCartAjax(currentQuickViewProduct.id, selectedQuickViewSize, selectedQuickViewColor, 1);
            closeQuickViewModal();
        }

        function handleNewsletter(e) {
            e.preventDefault();
            document.getElementById('newsletter-feedback').classList.remove('hidden');
            e.target.reset();
        }

        // Initialize cart summary on page load
        document.addEventListener('DOMContentLoaded', () => {
            refreshCartSummary();
        });
    </script>

    @stack('scripts')
</body>
</html>

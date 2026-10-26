@extends('layouts.app')

@section('title', 'AURELIA ATELIER — Spring/Summer 2026 Haute Ready-to-Wear')

@section('content')

    <!-- HERO EDITORIAL BANNER -->
    <section class="relative bg-[#FAFAF8] overflow-hidden border-b border-zinc-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center min-h-[75vh] py-12 lg:py-0">
                <!-- Text / Callout -->
                <div class="lg:col-span-5 space-y-6 text-center lg:text-left z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-white border border-zinc-200 text-[10px] tracking-[0.25em] uppercase font-bold text-zinc-800 shadow-2xs">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                        SS26 HAUTE READY-TO-WEAR
                    </div>

                    <h1 class="font-serif-luxury text-4xl sm:text-5xl lg:text-6xl text-zinc-950 font-normal leading-[1.1] tracking-tight">
                        A Study in <br>
                        <span class="italic font-light">Pure Monolith</span> & Tailoring.
                    </h1>

                    <p class="text-sm sm:text-base text-zinc-600 font-light leading-relaxed max-w-lg mx-auto lg:mx-0">
                        Architectural coats, featherlight heavy silks, and fluid trousers crafted in Florence. Designed to create an aura of effortless presence.
                    </p>

                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a href="{{ route('shop.index') }}" class="w-full sm:w-auto px-8 py-4 bg-zinc-950 text-white text-xs uppercase tracking-[0.22em] font-semibold hover:bg-zinc-800 transition shadow-lg text-center">
                            Explore Collection
                        </a>
                        <a href="{{ route('shop.index', ['category' => 'outerwear-coats']) }}" class="w-full sm:w-auto px-8 py-4 bg-white border border-zinc-300 text-zinc-900 text-xs uppercase tracking-[0.22em] font-semibold hover:border-zinc-950 transition text-center">
                            The Florence Coat
                        </a>
                    </div>

                    <!-- Micro-stat highlights -->
                    <div class="grid grid-cols-3 pt-6 border-t border-zinc-200/80 text-zinc-800 text-left max-w-md mx-auto lg:mx-0">
                        <div>
                            <p class="font-cinzel text-lg font-bold text-zinc-950">100%</p>
                            <p class="text-[10px] uppercase tracking-wider text-zinc-500">Virgin Fibers</p>
                        </div>
                        <div>
                            <p class="font-cinzel text-lg font-bold text-zinc-950">Biella</p>
                            <p class="text-[10px] uppercase tracking-wider text-zinc-500">Tuscan Mills</p>
                        </div>
                        <div>
                            <p class="font-cinzel text-lg font-bold text-zinc-950">30-Day</p>
                            <p class="text-[10px] uppercase tracking-wider text-zinc-500">Atelier Returns</p>
                        </div>
                    </div>
                </div>

                <!-- Hero Photography -->
                <div class="lg:col-span-7 relative">
                    <div class="relative mx-auto max-w-2xl lg:max-w-none overflow-hidden group">
                        <img src="{{ asset('images/hero/hero_main.jpg') }}" alt="Aurelia Atelier Spring/Summer 2026 Collection" class="w-full h-auto object-cover object-center max-h-[640px] shadow-2xl transition duration-700 group-hover:scale-102">
                        <!-- Floating Badge -->
                        <div class="absolute bottom-6 left-6 bg-white/90 backdrop-blur-md px-5 py-3 border border-white/60 shadow-lg hidden sm:block">
                            <p class="text-[10px] uppercase tracking-[0.2em] text-zinc-500 font-bold">Featured Ensemble</p>
                            <p class="text-xs font-serif-luxury font-medium text-zinc-900">Atelier Pearl Blazer & Fluid Silk Slip</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CURATED COLLECTIONS GRID -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-[11px] uppercase tracking-[0.25em] text-zinc-400 font-semibold block mb-2">Curated Wardrobe</span>
                <h2 class="font-serif-luxury text-3xl sm:text-4xl text-zinc-950 font-normal">Explore by Category</h2>
                <div class="w-12 h-px bg-zinc-900 mx-auto mt-4"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-6">
                @foreach($featuredCategories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="group block text-center">
                        <div class="aspect-3/4 bg-zinc-100 overflow-hidden mb-3 border border-zinc-200/80 relative">
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-108">
                            <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors"></div>
                        </div>
                        <h3 class="text-xs font-semibold uppercase tracking-[0.14em] text-zinc-900 group-hover:text-amber-800 transition">
                            {{ $category->name }}
                        </h3>
                        <p class="text-[11px] text-zinc-400 font-medium mt-0.5">Explore &rarr;</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- BESTSELLERS SHOWCASE -->
    <section class="py-20 bg-[#FAF9F6] border-y border-zinc-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <span class="text-[11px] uppercase tracking-[0.25em] text-zinc-400 font-semibold block mb-2">Iconic Silhouettes</span>
                    <h2 class="font-serif-luxury text-3xl sm:text-4xl text-zinc-950 font-normal">Atelier Bestsellers</h2>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('shop.index', ['sort' => 'bestseller']) }}" class="text-xs uppercase tracking-[0.2em] font-semibold text-zinc-800 hover:text-zinc-950 transition border-b border-zinc-900 pb-1">
                        View All Bestsellers &rarr;
                    </a>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                @foreach($bestsellers as $product)
                    <div class="group bg-white border border-zinc-200/80 overflow-hidden flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:border-zinc-300">
                        <div class="relative aspect-3/4 overflow-hidden bg-zinc-100">
                            <a href="{{ route('shop.show', $product->slug) }}">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                            </a>

                            <!-- Badges -->
                            <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10">
                                @if($product->is_new)
                                    <span class="bg-zinc-950 text-white text-[9px] uppercase tracking-[0.16em] font-bold px-2 py-0.5">NEW</span>
                                @endif
                                @if($product->compare_at_price)
                                    <span class="bg-rose-50 border border-rose-200 text-rose-800 text-[9px] uppercase tracking-wider font-bold px-2 py-0.5">
                                        SAVE {{ $product->discountPercentage() }}%
                                    </span>
                                @endif
                            </div>

                            <!-- Quick Action Buttons -->
                            <div class="absolute inset-x-3 bottom-3 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                                <button type="button" onclick="openQuickView({{ $product->id }})" class="flex-1 py-2.5 bg-white/95 backdrop-blur-sm text-zinc-900 text-[11px] uppercase tracking-wider font-semibold border border-zinc-200 hover:bg-zinc-950 hover:text-white transition shadow-md">
                                    Quick View
                                </button>
                                <button type="button" onclick="addToCartAjax({{ $product->id }})" class="px-3.5 py-2.5 bg-zinc-950 text-white text-xs hover:bg-zinc-800 transition shadow-md" title="Add to Bag">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="p-5 flex flex-col flex-1 justify-between">
                            <div>
                                <p class="text-[10px] uppercase tracking-[0.18em] text-zinc-400 font-semibold mb-1">
                                    {{ $product->category->name ?? 'Atelier' }}
                                </p>
                                <h3 class="text-sm font-serif-luxury font-medium text-zinc-950 group-hover:text-amber-900 transition truncate">
                                    <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                                </h3>
                                <p class="text-[11px] text-zinc-500 italic truncate mt-0.5">{{ $product->tagline }}</p>
                            </div>

                            <div class="mt-4 pt-3 border-t border-zinc-100 flex items-center justify-between">
                                <div class="flex items-baseline gap-2">
                                    <span class="font-cinzel text-base font-bold text-zinc-950">${{ number_format($product->price, 2) }}</span>
                                    @if($product->compare_at_price)
                                        <span class="text-xs text-zinc-400 line-through">${{ number_format($product->compare_at_price, 2) }}</span>
                                    @endif
                                </div>
                                <div class="flex items-center text-[10px] text-amber-500">
                                    <i class="fa-solid fa-star"></i>
                                    <span class="ml-1 text-zinc-700 font-semibold">5.0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- EDITORIAL CRAFT STORY -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="relative order-2 lg:order-1">
                    <div class="aspect-4/5 bg-zinc-100 overflow-hidden shadow-2xl border border-zinc-200">
                        <img src="{{ asset('images/products/cashmere_wool_coat.jpg') }}" alt="Italian Cashmere Craftsmanship" class="w-full h-full object-cover">
                    </div>
                    <!-- Secondary detail inset -->
                    <div class="absolute -bottom-6 -right-6 w-48 h-48 bg-white p-2 shadow-xl border border-zinc-200 hidden sm:block">
                        <img src="{{ asset('images/products/structured_wool_blazer.jpg') }}" alt="Hand-stitched tailoring" class="w-full h-full object-cover">
                    </div>
                </div>

                <div class="order-1 lg:order-2 space-y-6">
                    <span class="text-[11px] uppercase tracking-[0.25em] text-zinc-400 font-semibold block">Artisanal Provenance</span>
                    <h2 class="font-serif-luxury text-3xl sm:text-5xl text-zinc-950 font-normal leading-tight">
                        Woven in Tuscany, <br>
                        <span class="italic font-light">Engineered for a Lifetime.</span>
                    </h2>
                    <p class="text-sm text-zinc-600 leading-relaxed">
                        Every coat and blazer begins at century-old watermills along the Cervo river in Biella, where soft mountain waters wash virgin merino wool and Mongolian cashmere into cloud-soft yarns.
                    </p>
                    <p class="text-sm text-zinc-600 leading-relaxed">
                        Each collar is shaped by steam and hand-padded with natural horsehair canvas over eighteen hours. When you slide your arms into an Aurelia garment, you experience an unmistakable balance of structure and effortless lightness.
                    </p>

                    <div class="pt-4 flex items-center gap-6">
                        <a href="{{ route('shop.index') }}" class="px-8 py-3.5 bg-zinc-950 text-white text-xs uppercase tracking-[0.2em] font-semibold hover:bg-zinc-800 transition">
                            Explore The Tailoring
                        </a>
                        <span class="text-xs uppercase tracking-wider text-zinc-500 font-semibold">Florence &bull; Biella</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NEW ARRIVALS GRID -->
    <section class="py-20 bg-[#FCFCFA] border-t border-zinc-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <span class="text-[11px] uppercase tracking-[0.25em] text-zinc-400 font-semibold block mb-2">Just Landed</span>
                    <h2 class="font-serif-luxury text-3xl sm:text-4xl text-zinc-950 font-normal">New Season Arrivals</h2>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('shop.index') }}" class="text-xs uppercase tracking-[0.2em] font-semibold text-zinc-800 hover:text-zinc-950 transition border-b border-zinc-900 pb-1">
                        Discover Entire Wardrobe &rarr;
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                @foreach($newArrivals as $product)
                    <div class="group bg-white border border-zinc-200/80 overflow-hidden flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:border-zinc-300">
                        <div class="relative aspect-3/4 overflow-hidden bg-zinc-100">
                            <a href="{{ route('shop.show', $product->slug) }}">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                            </a>

                            <div class="absolute top-3 left-3 z-10">
                                <span class="bg-zinc-950 text-white text-[9px] uppercase tracking-[0.16em] font-bold px-2 py-0.5">NEW</span>
                            </div>

                            <div class="absolute inset-x-3 bottom-3 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                                <button type="button" onclick="openQuickView({{ $product->id }})" class="flex-1 py-2.5 bg-white/95 backdrop-blur-sm text-zinc-900 text-[11px] uppercase tracking-wider font-semibold border border-zinc-200 hover:bg-zinc-950 hover:text-white transition shadow-md">
                                    Quick View
                                </button>
                                <button type="button" onclick="addToCartAjax({{ $product->id }})" class="px-3.5 py-2.5 bg-zinc-950 text-white text-xs hover:bg-zinc-800 transition shadow-md" title="Add to Bag">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="p-5 flex flex-col flex-1 justify-between">
                            <div>
                                <p class="text-[10px] uppercase tracking-[0.18em] text-zinc-400 font-semibold mb-1">
                                    {{ $product->category->name ?? 'Atelier' }}
                                </p>
                                <h3 class="text-sm font-serif-luxury font-medium text-zinc-950 group-hover:text-amber-900 transition truncate">
                                    <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                                </h3>
                                <p class="text-[11px] text-zinc-500 italic truncate mt-0.5">{{ $product->tagline }}</p>
                            </div>

                            <div class="mt-4 pt-3 border-t border-zinc-100 flex items-center justify-between">
                                <div class="flex items-baseline gap-2">
                                    <span class="font-cinzel text-base font-bold text-zinc-950">${{ number_format($product->price, 2) }}</span>
                                    @if($product->compare_at_price)
                                        <span class="text-xs text-zinc-400 line-through">${{ number_format($product->compare_at_price, 2) }}</span>
                                    @endif
                                </div>
                                <span class="text-[10px] uppercase font-bold tracking-wider text-emerald-700">In Stock</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CLIENT TESTIMONIALS -->
    <section class="py-20 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-[11px] uppercase tracking-[0.25em] text-zinc-400 font-semibold block mb-3">Client Reflections</span>
            <div class="flex justify-center text-amber-500 text-sm gap-1 mb-6">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
            </div>
            <blockquote class="font-serif-luxury text-2xl sm:text-3xl text-zinc-900 italic font-normal leading-relaxed max-w-3xl mx-auto">
                &ldquo;The Florence Cashmere Coat is sublime. The clean white tailoring and weight of the double-faced fabric hold an presence that turns heads wherever I walk in Manhattan.&rdquo;
            </blockquote>
            <p class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-950 mt-6">&mdash; Lady Eleanor St. John, New York & London</p>
            <p class="text-[11px] text-zinc-400 mt-1">Verified Client &bull; 6 Atelier Acquisitions</p>
        </div>
    </section>

@endsection

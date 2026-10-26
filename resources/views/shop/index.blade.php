@extends('layouts.app')

@section('title', ($selectedCategory ? $selectedCategory->name : 'All Collections') . ' — AURELIA ATELIER')

@section('content')

    <!-- Catalog Header & Breadcrumb -->
    <div class="bg-[#FAFAFA] border-b border-zinc-200 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-zinc-500 mb-3 uppercase tracking-wider">
                <a href="{{ route('home') }}" class="hover:text-zinc-900 transition">Home</a>
                <span class="mx-2 text-zinc-300">/</span>
                <a href="{{ route('shop.index') }}" class="hover:text-zinc-900 transition">Collections</a>
                @if($selectedCategory)
                    <span class="mx-2 text-zinc-300">/</span>
                    <span class="text-zinc-900 font-semibold">{{ $selectedCategory->name }}</span>
                @elseif(request('q'))
                    <span class="mx-2 text-zinc-300">/</span>
                    <span class="text-zinc-900 font-semibold">Search: "{{ request('q') }}"</span>
                @endif
            </nav>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="font-serif-luxury text-3xl sm:text-4xl text-zinc-950 font-normal">
                        {{ $selectedCategory ? $selectedCategory->name : (request('q') ? 'Search Results' : 'The Complete Atelier Wardrobe') }}
                    </h1>
                    <p class="text-xs text-zinc-500 max-w-xl mt-1.5 leading-relaxed">
                        {{ $selectedCategory ? $selectedCategory->description : 'Handcrafted coats, sculpted blazers, fluid silks, and tailored trousers.' }}
                    </p>
                </div>
                <div class="text-xs text-zinc-500 uppercase tracking-wider font-medium">
                    Showing <span class="font-bold text-zinc-900">{{ $products->total() }}</span> pieces
                </div>
            </div>
        </div>
    </div>

    <!-- Catalog Main Area -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <!-- Sidebar Filters -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Search Query Reset -->
                @if(request('q') || request('category') || request('min_price') || request('max_price') || request('in_stock'))
                    <div class="p-3 bg-zinc-100 rounded text-xs flex items-center justify-between">
                        <span class="font-medium text-zinc-700">Filters active</span>
                        <a href="{{ route('shop.index') }}" class="text-rose-600 hover:underline font-semibold">Clear All</a>
                    </div>
                @endif

                <!-- Category Accordion / List -->
                <div>
                    <h3 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-900 pb-3 border-b border-zinc-200 mb-4">
                        Categories
                    </h3>
                    <ul class="space-y-2 text-xs">
                        <li>
                            <a href="{{ route('shop.index', request()->except('category', 'page')) }}" class="flex items-center justify-between py-1 transition {{ !request('category') ? 'font-bold text-zinc-950' : 'text-zinc-600 hover:text-zinc-900' }}">
                                <span>All Categories</span>
                                <span class="text-zinc-400">({{ \App\Models\Product::count() }})</span>
                            </a>
                        </li>
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('shop.index', array_merge(request()->except('page'), ['category' => $cat->slug])) }}" class="flex items-center justify-between py-1 transition {{ request('category') === $cat->slug ? 'font-bold text-zinc-950' : 'text-zinc-600 hover:text-zinc-900' }}">
                                    <span>{{ $cat->name }}</span>
                                    <span class="text-zinc-400">({{ $cat->products_count }})</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Price Filter -->
                <form action="{{ route('shop.index') }}" method="GET" class="space-y-4">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('q'))
                        <input type="hidden" name="q" value="{{ request('q') }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <h3 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-900 pb-3 border-b border-zinc-200">
                        Price Range
                    </h3>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div>
                            <label class="text-[10px] uppercase text-zinc-400 font-semibold block mb-1">Min ($)</label>
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0" class="w-full px-3 py-2 border border-zinc-300 text-xs focus:outline-none focus:border-zinc-900">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase text-zinc-400 font-semibold block mb-1">Max ($)</label>
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="1500" class="w-full px-3 py-2 border border-zinc-300 text-xs focus:outline-none focus:border-zinc-900">
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-1">
                        <input type="checkbox" id="in_stock" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }} class="rounded border-zinc-300 text-zinc-900 focus:ring-0">
                        <label for="in_stock" class="text-xs text-zinc-700 font-medium">In-stock pieces only</label>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-zinc-900 text-white text-xs uppercase tracking-wider font-semibold hover:bg-zinc-800 transition">
                        Apply Filter
                    </button>
                </form>

                <!-- Value Proposition Box -->
                <div class="p-5 bg-[#F9F8F5] border border-zinc-200/80 text-xs space-y-2">
                    <p class="font-bold text-zinc-900 uppercase tracking-wider text-[11px]">Bespoke Concierge</p>
                    <p class="text-zinc-600 leading-relaxed text-[11px]">
                        Need guidance on fit, sizing, or styling an ensemble? Our stylists are available 7 days a week.
                    </p>
                    <a href="mailto:concierge@aurelia.com" class="inline-block text-[11px] font-bold text-zinc-900 underline pt-1">
                        Contact Stylist &rarr;
                    </a>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="lg:col-span-3">

                <!-- Sort & Controls Toolbar -->
                <div class="flex flex-col sm:flex-row items-center justify-between pb-6 mb-6 border-b border-zinc-200 gap-4">
                    <div class="text-xs text-zinc-500">
                        Showing {{ $products->firstItem() ?? 0 }} &ndash; {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                    </div>

                    <div class="flex items-center gap-3">
                        <label for="sort-select" class="text-xs uppercase tracking-wider text-zinc-500 font-semibold whitespace-nowrap">Sort By:</label>
                        <select id="sort-select" onchange="location = this.value;" class="border border-zinc-300 text-xs py-2 pl-3 pr-8 bg-white focus:outline-none focus:border-zinc-900 font-medium">
                            <option value="{{ route('shop.index', array_merge(request()->query(), ['sort' => 'newest'])) }}" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                            <option value="{{ route('shop.index', array_merge(request()->query(), ['sort' => 'bestseller'])) }}" {{ request('sort') === 'bestseller' ? 'selected' : '' }}>Bestsellers</option>
                            <option value="{{ route('shop.index', array_merge(request()->query(), ['sort' => 'price_asc'])) }}" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="{{ route('shop.index', array_merge(request()->query(), ['sort' => 'price_desc'])) }}" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>
                </div>

                @if($products->isEmpty())
                    <div class="text-center py-20 bg-zinc-50 border border-zinc-200">
                        <i class="fa-regular fa-bag-shopping text-4xl text-zinc-300 mb-3"></i>
                        <h3 class="text-sm uppercase tracking-wider font-bold text-zinc-800">No matching pieces found</h3>
                        <p class="text-xs text-zinc-500 mt-1">Try relaxing your price filters or searching for another term.</p>
                        <a href="{{ route('shop.index') }}" class="mt-4 inline-block px-6 py-2.5 bg-zinc-900 text-white text-xs uppercase tracking-wider font-semibold">
                            Reset All Filters
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
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

                                    <!-- Quick Actions -->
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
                                            {{ $product->category->name ?? 'Collection' }}
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

                                        @if($product->stock > 0)
                                            <span class="text-[10px] uppercase font-bold tracking-wider text-emerald-700">In Stock</span>
                                        @else
                                            <span class="text-[10px] uppercase font-bold tracking-wider text-rose-600">Waitlist</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

@endsection

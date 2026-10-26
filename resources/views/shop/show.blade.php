@extends('layouts.app')

@section('title', $product->name . ' — AURELIA ATELIER')
@section('meta_description', Str::limit($product->description, 160))

@section('content')

    <!-- Breadcrumbs -->
    <div class="bg-[#FAFAFA] border-b border-zinc-200 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs text-zinc-500 uppercase tracking-wider">
                <a href="{{ route('home') }}" class="hover:text-zinc-900 transition">Home</a>
                <span class="mx-2 text-zinc-300">/</span>
                <a href="{{ route('shop.index') }}" class="hover:text-zinc-900 transition">Collections</a>
                @if($product->category)
                    <span class="mx-2 text-zinc-300">/</span>
                    <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-zinc-900 transition">{{ $product->category->name }}</a>
                @endif
                <span class="mx-2 text-zinc-300">/</span>
                <span class="text-zinc-900 font-semibold truncate">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Product Showcase Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

            <!-- Product Gallery (Left) -->
            <div class="lg:col-span-7 space-y-4">
                <div class="aspect-3/4 bg-zinc-100 overflow-hidden border border-zinc-200 relative group">
                    <img id="main-product-image" src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 cursor-zoom-in">
                    
                    @if($product->is_new)
                        <span class="absolute top-4 left-4 bg-zinc-950 text-white text-[9px] uppercase tracking-[0.2em] font-bold px-3 py-1">
                            NEW ATELIER RELEASE
                        </span>
                    @endif
                </div>

                @if(!empty($product->gallery) && count($product->gallery) > 1)
                    <div class="grid grid-cols-4 gap-3">
                        @foreach($product->gallery as $galImg)
                            <button type="button" onclick="document.getElementById('main-product-image').src = '{{ asset($galImg) }}'" class="aspect-square bg-zinc-100 border border-zinc-200 hover:border-zinc-900 overflow-hidden transition">
                                <img src="{{ asset($galImg) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Purchase Details (Right) -->
            <div class="lg:col-span-5 flex flex-col justify-between">
                <div>
                    <!-- Category & SKU -->
                    <div class="flex items-center justify-between text-[11px] uppercase tracking-[0.2em] text-zinc-400 font-semibold mb-2">
                        <span>{{ $product->category->name ?? 'Collection' }}</span>
                        <span>SKU: {{ $product->sku }}</span>
                    </div>

                    <!-- Title -->
                    <h1 class="font-serif-luxury text-3xl sm:text-4xl text-zinc-950 font-normal leading-tight mb-2">
                        {{ $product->name }}
                    </h1>

                    <!-- Tagline -->
                    <p class="text-xs text-amber-900/80 italic font-medium mb-4">
                        {{ $product->tagline }}
                    </p>

                    <!-- Reviews summary -->
                    <div class="flex items-center gap-2 mb-6 text-xs text-zinc-600">
                        <div class="flex text-amber-500 text-xs">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="font-bold text-zinc-900">{{ $product->averageRating() }}</span>
                        <span class="text-zinc-400">&bull;</span>
                        <a href="#reviews" class="text-zinc-600 underline hover:text-zinc-900">{{ $product->reviewsCount() }} Verified Reviews</a>
                    </div>

                    <!-- Price -->
                    <div class="flex items-baseline gap-3 pb-6 border-b border-zinc-200">
                        <span class="font-cinzel text-3xl font-bold text-zinc-950">${{ number_format($product->price, 2) }}</span>
                        @if($product->compare_at_price)
                            <span class="text-base text-zinc-400 line-through">${{ number_format($product->compare_at_price, 2) }}</span>
                            <span class="text-xs bg-rose-50 border border-rose-200 text-rose-800 font-bold px-2.5 py-0.5">
                                SAVE {{ $product->discountPercentage() }}%
                            </span>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="py-6 border-b border-zinc-200 text-xs text-zinc-600 leading-relaxed space-y-3">
                        <p>{{ $product->description }}</p>
                    </div>

                    <!-- Interactive Form -->
                    <form id="add-to-bag-form" action="{{ route('cart.add') }}" method="POST" class="py-6 space-y-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <!-- Shade / Color Swatches -->
                        <div>
                            <span class="text-xs uppercase tracking-wider font-bold text-zinc-900 block mb-2.5">
                                Select Shade: <span id="selected-color-label" class="text-zinc-500 font-normal">Ivory Cream</span>
                            </span>
                            <div class="flex flex-wrap gap-2.5">
                                @php
                                    $colors = $product->available_colors ?: [['name' => 'Alabaster White', 'hex' => '#FFFFFF']];
                                @endphp
                                @foreach($colors as $idx => $color)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="color" value="{{ $color['name'] }}" {{ $idx === 0 ? 'checked' : '' }} class="sr-only peer" onchange="document.getElementById('selected-color-label').textContent = '{{ $color['name'] }}'">
                                        <div class="px-3.5 py-1.5 border border-zinc-300 peer-checked:border-zinc-950 peer-checked:bg-zinc-100 flex items-center gap-2 text-xs text-zinc-800 font-medium transition hover:border-zinc-900">
                                            <span class="w-3 h-3 rounded-full border border-zinc-300 inline-block" style="background-color: {{ $color['hex'] }}"></span>
                                            <span>{{ $color['name'] }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Size Selector -->
                        <div>
                            <div class="flex items-center justify-between mb-2.5">
                                <span class="text-xs uppercase tracking-wider font-bold text-zinc-900">
                                    Select Size: <span id="selected-size-label" class="text-zinc-500 font-normal">{{ $product->available_sizes[0] ?? 'M' }}</span>
                                </span>
                                <button type="button" onclick="openSizeGuideModal()" class="text-xs text-zinc-500 hover:text-zinc-950 underline underline-offset-2 flex items-center gap-1">
                                    <i class="fa-solid fa-ruler-horizontal text-[10px]"></i> Sizing Guide
                                </button>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $sizes = $product->available_sizes ?: ['XS', 'S', 'M', 'L'];
                                @endphp
                                @foreach($sizes as $idx => $size)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="size" value="{{ $size }}" {{ $idx === 0 ? 'checked' : '' }} class="sr-only peer" onchange="document.getElementById('selected-size-label').textContent = '{{ $size }}'">
                                        <div class="w-12 h-11 border border-zinc-300 peer-checked:border-zinc-950 peer-checked:bg-zinc-950 peer-checked:text-white flex items-center justify-center text-xs font-bold transition hover:border-zinc-900">
                                            {{ $size }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Quantity & Buttons -->
                        <div class="space-y-3 pt-2">
                            <div class="flex gap-4">
                                <!-- Quantity Stepper -->
                                <div class="flex items-center border border-zinc-300 w-32 h-13">
                                    <button type="button" onclick="adjustQty(-1)" class="w-10 h-full text-zinc-500 hover:text-zinc-900 hover:bg-zinc-50 transition">-</button>
                                    <input type="number" id="purchase-qty" name="quantity" value="1" min="1" max="10" class="w-12 text-center text-xs font-bold text-zinc-900 border-none focus:outline-none">
                                    <button type="button" onclick="adjustQty(1)" class="w-10 h-full text-zinc-500 hover:text-zinc-900 hover:bg-zinc-50 transition">+</button>
                                </div>

                                <!-- Add to Bag (AJAX slide drawer) -->
                                <button type="button" onclick="submitProductToBag()" class="flex-1 h-13 bg-zinc-950 text-white text-xs uppercase tracking-[0.2em] font-bold hover:bg-zinc-800 transition shadow-lg flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-bag-shopping"></i> Add to Bag
                                </button>
                            </div>

                            <!-- Buy Now (Express Direct) -->
                            <button type="submit" formaction="{{ route('cart.add') }}" class="w-full h-12 bg-white border border-zinc-950 text-zinc-950 text-xs uppercase tracking-[0.2em] font-bold hover:bg-zinc-50 transition">
                                Buy Now with Express Checkout
                            </button>
                        </div>
                    </form>

                    <!-- Stock & Production Alert -->
                    <div class="pt-4 flex items-center gap-2 text-xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                        <span class="text-zinc-600 font-medium">
                            Limited production run: <span class="text-zinc-950 font-bold">{{ $product->stock }} pieces available</span>.
                        </span>
                    </div>
                </div>

                <!-- Product Accordions -->
                <div class="mt-8 border-t border-zinc-200 divide-y divide-zinc-200 text-xs">
                    <details class="group py-4">
                        <summary class="flex justify-between items-center cursor-pointer font-bold text-zinc-900 uppercase tracking-wider">
                            <span>Materials & Craftsmanship</span>
                            <span class="group-open:rotate-180 transition-transform"><i class="fa-solid fa-chevron-down text-[10px]"></i></span>
                        </summary>
                        <div class="mt-3 text-zinc-600 leading-relaxed pl-1">
                            <p>{{ $product->material_care ?: 'Hand-finished in Italy from bespoke natural fibers. Clean dry clean recommended.' }}</p>
                        </div>
                    </details>

                    <details class="group py-4">
                        <summary class="flex justify-between items-center cursor-pointer font-bold text-zinc-900 uppercase tracking-wider">
                            <span>Complimentary Global Delivery</span>
                            <span class="group-open:rotate-180 transition-transform"><i class="fa-solid fa-chevron-down text-[10px]"></i></span>
                        </summary>
                        <div class="mt-3 text-zinc-600 leading-relaxed pl-1 space-y-1">
                            <p>&bull; Complimentary white-glove express shipping on orders over $150.</p>
                            <p>&bull; Delivered in bespoke archive gift boxes with cedar dust bags.</p>
                            <p>&bull; 30-day effortless returns with pre-paid insured shipping label.</p>
                        </div>
                    </details>
                </div>
            </div>

        </div>
    </div>

    <!-- CUSTOMER REVIEWS SECTION -->
    <section id="reviews" class="py-16 bg-[#FAFAF8] border-t border-zinc-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 pb-6 border-b border-zinc-200 gap-4">
                <div>
                    <span class="text-[11px] uppercase tracking-[0.25em] text-zinc-400 font-semibold block mb-1">Client Reflections</span>
                    <h2 class="font-serif-luxury text-3xl text-zinc-950 font-normal">Customer Testimonials</h2>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="flex text-amber-500 text-sm">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="font-bold text-sm text-zinc-900">{{ $product->averageRating() }} out of 5</span>
                        <span class="text-xs text-zinc-500">({{ $product->reviewsCount() }} total reviews)</span>
                    </div>
                </div>

                <button type="button" onclick="document.getElementById('write-review-form').classList.toggle('hidden')" class="px-5 py-2.5 bg-zinc-950 text-white text-xs uppercase tracking-wider font-semibold hover:bg-zinc-800 transition">
                    Write A Review
                </button>
            </div>

            <!-- Write Review Form (Collapsible) -->
            <div id="write-review-form" class="hidden mb-12 bg-white p-6 border border-zinc-200 shadow-sm">
                <h3 class="text-sm uppercase tracking-wider font-bold text-zinc-900 mb-4">Share Your Atelier Experience</h3>
                <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block font-semibold text-zinc-700 mb-1">Your Name *</label>
                            <input type="text" name="user_name" required value="{{ auth()->user()->name ?? '' }}" class="w-full px-3 py-2 border border-zinc-300 focus:outline-none focus:border-zinc-900">
                        </div>
                        <div>
                            <label class="block font-semibold text-zinc-700 mb-1">Rating *</label>
                            <select name="rating" class="w-full px-3 py-2 border border-zinc-300 focus:outline-none focus:border-zinc-900 font-medium">
                                <option value="5">★★★★★ — Exceptional Quality (5 Stars)</option>
                                <option value="4">★★★★☆ — Very Good (4 Stars)</option>
                                <option value="3">★★★☆☆ — Average (3 Stars)</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-xs">
                        <label class="block font-semibold text-zinc-700 mb-1">Review Headline</label>
                        <input type="text" name="title" placeholder="e.g. Masterful fit and luxurious hand-feel" class="w-full px-3 py-2 border border-zinc-300 focus:outline-none focus:border-zinc-900">
                    </div>
                    <div class="text-xs">
                        <label class="block font-semibold text-zinc-700 mb-1">Your Feedback *</label>
                        <textarea name="comment" rows="3" required placeholder="Describe the tailoring, drape, comfort, and compliments received..." class="w-full px-3 py-2 border border-zinc-300 focus:outline-none focus:border-zinc-900"></textarea>
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-zinc-900 text-white text-xs uppercase tracking-wider font-semibold hover:bg-zinc-800 transition">
                        Publish Review
                    </button>
                </form>
            </div>

            <!-- Reviews List -->
            <div class="space-y-6">
                @forelse($product->reviews as $review)
                    <div class="bg-white p-6 border border-zinc-200/80 shadow-2xs">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-xs text-zinc-900">{{ $review->user_name }}</span>
                                @if($review->is_verified)
                                    <span class="inline-flex items-center gap-1 text-[10px] text-emerald-700 bg-emerald-50 px-2 py-0.5 font-semibold">
                                        <i class="fa-solid fa-circle-check text-[9px]"></i> Verified Acquisition
                                    </span>
                                @endif
                            </div>
                            <span class="text-[11px] text-zinc-400">{{ $review->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex text-amber-500 text-xs mb-2">
                            @for($i = 0; $i < $review->rating; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </div>
                        @if($review->title)
                            <h4 class="text-xs font-bold text-zinc-900 mb-1 font-serif-luxury">{{ $review->title }}</h4>
                        @endif
                        <p class="text-xs text-zinc-600 leading-relaxed">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-xs text-zinc-500 italic">Be the first client to submit a review for this piece.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- RELATED PRODUCTS -->
    @if($relatedProducts->isNotEmpty())
        <section class="py-20 bg-white border-t border-zinc-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <span class="text-[11px] uppercase tracking-[0.25em] text-zinc-400 font-semibold block mb-1">Wardrobe Harmonies</span>
                    <h2 class="font-serif-luxury text-3xl text-zinc-950 font-normal">Complete The Silhouette</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $rel)
                        <div class="group bg-white border border-zinc-200/80 overflow-hidden flex flex-col justify-between transition-all duration-300 hover:shadow-xl">
                            <div class="aspect-3/4 overflow-hidden bg-zinc-100 relative">
                                <a href="{{ route('shop.show', $rel->slug) }}">
                                    <img src="{{ asset($rel->image) }}" alt="{{ $rel->name }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                                </a>
                            </div>
                            <div class="p-4">
                                <p class="text-[10px] uppercase tracking-wider text-zinc-400 font-semibold mb-1">{{ $rel->category->name ?? '' }}</p>
                                <h3 class="text-xs font-serif-luxury font-medium text-zinc-900 truncate">
                                    <a href="{{ route('shop.show', $rel->slug) }}">{{ $rel->name }}</a>
                                </h3>
                                <p class="font-cinzel text-xs font-bold text-zinc-950 mt-2">${{ number_format($rel->price, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection

@push('scripts')
<script>
    function adjustQty(change) {
        const input = document.getElementById('purchase-qty');
        let current = parseInt(input.value) || 1;
        current += change;
        if (current < 1) current = 1;
        if (current > 10) current = 10;
        input.value = current;
    }

    function submitProductToBag() {
        const form = document.getElementById('add-to-bag-form');
        const sizeInput = form.querySelector('input[name="size"]:checked');
        const colorInput = form.querySelector('input[name="color"]:checked');
        const qty = parseInt(document.getElementById('purchase-qty').value) || 1;

        const size = sizeInput ? sizeInput.value : 'Regular';
        const color = colorInput ? colorInput.value : 'White';

        addToCartAjax({{ $product->id }}, size, color, qty);
    }
</script>
@endpush

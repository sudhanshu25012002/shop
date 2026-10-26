@extends('layouts.app')

@section('title', 'Your Shopping Bag — AURELIA ATELIER')

@section('content')

    <div class="bg-[#FAFAFA] border-b border-zinc-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif-luxury text-3xl sm:text-4xl text-zinc-950 font-normal">Your Shopping Bag</h1>
            <p class="text-xs text-zinc-500 mt-1 uppercase tracking-wider">SS26 Ready-to-Wear Atelier Selection</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if(empty($cart))
            <div class="text-center py-20 bg-white border border-zinc-200 p-8 max-w-xl mx-auto">
                <i class="fa-regular fa-bag-shopping text-5xl text-zinc-300 mb-4"></i>
                <h2 class="text-base font-bold uppercase tracking-wider text-zinc-900 mb-1">Your bag is empty</h2>
                <p class="text-xs text-zinc-500 mb-6">Discover our latest collection of handcrafted coats, blazers, and pure mulberry silks.</p>
                <a href="{{ route('shop.index') }}" class="inline-block px-8 py-3.5 bg-zinc-950 text-white text-xs uppercase tracking-[0.2em] font-semibold hover:bg-zinc-800 transition">
                    Explore Collections
                </a>
            </div>
        @else
            <!-- Free Shipping Progress -->
            <div class="mb-8 p-4 bg-amber-50/70 border border-amber-200/80 rounded-none max-w-4xl mx-auto">
                <div class="flex items-center justify-between text-xs font-semibold text-amber-950 mb-2">
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-truck-fast"></i>
                        Complimentary White-Glove Shipping
                    </span>
                    <span>
                        @if($subtotal >= $freeShippingThreshold)
                            <span class="text-emerald-700 font-bold"><i class="fa-solid fa-circle-check"></i> Unlocked</span>
                        @else
                            Add ${{ number_format($shippingNeeded, 2) }} more to unlock
                        @endif
                    </span>
                </div>
                <div class="w-full bg-amber-200/60 rounded-full h-2 overflow-hidden">
                    <div class="bg-amber-600 h-2 rounded-full transition-all duration-500" style="width: {{ $shippingProgress }}%"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                <!-- Items Table (Left) -->
                <div class="lg:col-span-8">
                    <div class="bg-white border border-zinc-200">
                        <div class="hidden sm:grid grid-cols-12 gap-4 px-6 py-3.5 bg-zinc-50 border-b border-zinc-200 text-[11px] uppercase tracking-wider text-zinc-500 font-semibold">
                            <div class="col-span-6">Piece</div>
                            <div class="col-span-2 text-center">Price</div>
                            <div class="col-span-2 text-center">Quantity</div>
                            <div class="col-span-2 text-right">Total</div>
                        </div>

                        <div class="divide-y divide-zinc-100">
                            @foreach($cart as $key => $item)
                                <div class="p-6 grid grid-cols-1 sm:grid-cols-12 gap-4 items-center">
                                    <!-- Image & Name -->
                                    <div class="sm:col-span-6 flex gap-4 items-center">
                                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-20 h-26 object-cover bg-zinc-100 border border-zinc-200 flex-shrink-0">
                                        <div>
                                            <h3 class="text-xs font-bold text-zinc-900 font-serif-luxury sm:text-sm">
                                                <a href="{{ route('shop.show', $item['slug'] ?? '') }}" class="hover:underline">{{ $item['name'] }}</a>
                                            </h3>
                                            <p class="text-[11px] text-zinc-500 mt-1">Size: <span class="font-semibold text-zinc-800">{{ $item['size'] }}</span></p>
                                            <p class="text-[11px] text-zinc-500">Shade: <span class="font-semibold text-zinc-800">{{ $item['color'] }}</span></p>
                                            <form action="{{ route('cart.remove') }}" method="POST" class="mt-2">
                                                @csrf
                                                <input type="hidden" name="key" value="{{ $key }}">
                                                <button type="submit" class="text-[11px] text-zinc-400 hover:text-rose-600 transition flex items-center gap-1">
                                                    <i class="fa-regular fa-trash-can text-[10px]"></i> Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Unit Price -->
                                    <div class="sm:col-span-2 text-left sm:text-center">
                                        <span class="sm:hidden text-xs text-zinc-400 mr-2">Price:</span>
                                        <span class="font-cinzel text-xs font-bold text-zinc-950">${{ number_format($item['price'], 2) }}</span>
                                    </div>

                                    <!-- Quantity Stepper -->
                                    <div class="sm:col-span-2 flex justify-start sm:justify-center">
                                        <form action="{{ route('cart.update') }}" method="POST" class="flex items-center border border-zinc-300">
                                            @csrf
                                            <input type="hidden" name="key" value="{{ $key }}">
                                            <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="px-2.5 py-1 text-xs text-zinc-500 hover:bg-zinc-100">-</button>
                                            <span class="px-3 py-1 text-xs font-bold text-zinc-900">{{ $item['quantity'] }}</span>
                                            <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="px-2.5 py-1 text-xs text-zinc-500 hover:bg-zinc-100">+</button>
                                        </form>
                                    </div>

                                    <!-- Line Total -->
                                    <div class="sm:col-span-2 text-left sm:text-right">
                                        <span class="sm:hidden text-xs text-zinc-400 mr-2">Total:</span>
                                        <span class="font-cinzel text-sm font-bold text-zinc-950">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Table Footer actions -->
                        <div class="p-4 bg-zinc-50/70 border-t border-zinc-200 flex items-center justify-between">
                            <a href="{{ route('shop.index') }}" class="text-xs uppercase tracking-wider font-semibold text-zinc-700 hover:text-zinc-950 flex items-center gap-1.5">
                                &larr; Continue Browsing
                            </a>
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs text-rose-600 hover:underline font-medium">
                                    Clear Entire Bag
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Summary Card (Right) -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white border border-zinc-200 p-6 shadow-xs space-y-4">
                        <h2 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-950 pb-3 border-b border-zinc-200">
                            Order Summary
                        </h2>

                        <div class="space-y-3 text-xs">
                            <div class="flex justify-between text-zinc-600">
                                <span>Bag Subtotal</span>
                                <span class="font-cinzel font-bold text-zinc-900">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-zinc-600">
                                <span>Standard Express Delivery</span>
                                <span>{{ $subtotal >= $freeShippingThreshold ? 'Complimentary ($0.00)' : '$25.00' }}</span>
                            </div>
                            <div class="flex justify-between text-zinc-600">
                                <span>Estimated Sales Tax (8%)</span>
                                <span>${{ number_format($subtotal * 0.08, 2) }}</span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-zinc-200 flex justify-between items-baseline">
                            <span class="text-xs uppercase tracking-wider font-bold text-zinc-950">Estimated Total</span>
                            <span class="font-cinzel text-2xl font-bold text-zinc-950">
                                ${{ number_format($subtotal + ($subtotal >= $freeShippingThreshold ? 0 : 25) + ($subtotal * 0.08), 2) }}
                            </span>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="block w-full py-4 bg-zinc-950 text-white text-xs uppercase tracking-[0.2em] font-bold text-center hover:bg-zinc-800 transition shadow-lg">
                            Proceed to Checkout &rarr;
                        </a>

                        <div class="pt-3 text-center text-[11px] text-zinc-400 space-y-1">
                            <p><i class="fa-solid fa-lock text-[10px] mr-1"></i> 256-Bit SSL Encrypted Checkout</p>
                            <p>Complimentary 30-day effortless returns & exchanges.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection

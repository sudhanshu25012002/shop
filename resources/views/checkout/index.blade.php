@extends('layouts.app')

@section('title', 'Atelier Checkout — AURELIA ATELIER')

@section('content')

    <div class="bg-[#FAFAFA] border-b border-zinc-200 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif-luxury text-2xl sm:text-3xl text-zinc-950 font-normal">Secure Atelier Checkout</h1>
            <p class="text-xs text-zinc-500 mt-1 uppercase tracking-wider">Discreet Packaging & Complimented Express Logistics</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            <!-- Checkout Form (Left) -->
            <div class="lg:col-span-7">
                <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- 1. Contact Information -->
                    <div class="bg-white p-6 border border-zinc-200 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-zinc-100">
                            <h2 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-900 flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-zinc-950 text-white inline-flex items-center justify-center text-[10px]">1</span>
                                Contact Details
                            </h2>
                            @guest
                                <a href="{{ route('login') }}" class="text-xs text-zinc-500 hover:text-zinc-900 underline">Have an account? Sign in</a>
                            @endguest
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <div class="sm:col-span-2">
                                <label class="block font-semibold text-zinc-700 mb-1">Full Legal Name *</label>
                                <input type="text" name="customer_name" required value="{{ old('customer_name', $user->name ?? 'Sophia Laurent') }}" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 font-medium">
                            </div>
                            <div>
                                <label class="block font-semibold text-zinc-700 mb-1">Email Address (Order Confirmation) *</label>
                                <input type="email" name="customer_email" required value="{{ old('customer_email', $user->email ?? 'sophia.laurent@example.com') }}" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 font-medium">
                            </div>
                            <div>
                                <label class="block font-semibold text-zinc-700 mb-1">Mobile Telephone (Courier Updates) *</label>
                                <input type="tel" name="customer_phone" required value="{{ old('customer_phone', $user->phone ?? '+1 (555) 876-5432') }}" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 font-medium">
                            </div>
                        </div>
                    </div>

                    <!-- 2. Shipping Address -->
                    <div class="bg-white p-6 border border-zinc-200 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-zinc-100">
                            <h2 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-900 flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-zinc-950 text-white inline-flex items-center justify-center text-[10px]">2</span>
                                Shipping Address
                            </h2>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <div class="sm:col-span-2">
                                <label class="block font-semibold text-zinc-700 mb-1">Street Address, Suite / Penthouse *</label>
                                <input type="text" name="shipping_address" required value="{{ old('shipping_address', $user->address ?? '124 Mercer Street, Suite 4') }}" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 font-medium">
                            </div>
                            <div>
                                <label class="block font-semibold text-zinc-700 mb-1">City / Municipality *</label>
                                <input type="text" name="shipping_city" required value="{{ old('shipping_city', $user->city ?? 'New York') }}" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 font-medium">
                            </div>
                            <div>
                                <label class="block font-semibold text-zinc-700 mb-1">Postal Code / Zip *</label>
                                <input type="text" name="shipping_postal_code" required value="{{ old('shipping_postal_code', $user->postal_code ?? '10012') }}" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 font-medium">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block font-semibold text-zinc-700 mb-1">Country / Territory *</label>
                                <select name="shipping_country" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 font-medium bg-white">
                                    <option value="United States" selected>United States</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="France">France</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Canada">Canada</option>
                                </select>
                            </div>
                        </div>

                        <div class="pt-2 text-xs">
                            <label class="block font-semibold text-zinc-700 mb-1">Special Concierge Delivery Notes</label>
                            <input type="text" name="notes" placeholder="e.g. Leave with doorman, ring bell #4, gift packaging requested" class="w-full px-3.5 py-2 border border-zinc-300 focus:outline-none focus:border-zinc-900 text-xs">
                        </div>
                    </div>

                    <!-- 3. Payment Method Simulation -->
                    <div class="bg-white p-6 border border-zinc-200 space-y-4">
                        <div class="pb-3 border-b border-zinc-100">
                            <h2 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-900 flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-zinc-950 text-white inline-flex items-center justify-center text-[10px]">3</span>
                                Payment Method
                            </h2>
                        </div>

                        <div class="space-y-3">
                            <!-- Option 1: Credit / Debit Card -->
                            <label class="block border border-zinc-300 p-4 cursor-pointer hover:border-zinc-900 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="card" checked class="text-zinc-900 focus:ring-0">
                                        <span class="text-xs font-bold text-zinc-900">Credit / Debit Card (Immediate Settlement)</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-zinc-400 text-sm">
                                        <i class="fa-brands fa-cc-visa"></i>
                                        <i class="fa-brands fa-cc-mastercard"></i>
                                        <i class="fa-brands fa-cc-amex"></i>
                                    </div>
                                </div>
                                <div id="card-fields" class="mt-4 pt-4 border-t border-zinc-100 grid grid-cols-2 gap-3 text-xs">
                                    <div class="col-span-2">
                                        <label class="block text-[10px] uppercase text-zinc-500 font-semibold mb-1">Card Number</label>
                                        <input type="text" placeholder="•••• •••• •••• 4242" value="•••• •••• •••• 4242" class="w-full px-3 py-2 border border-zinc-300 font-mono text-xs focus:outline-none focus:border-zinc-900">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] uppercase text-zinc-500 font-semibold mb-1">Expires (MM/YY)</label>
                                        <input type="text" placeholder="12/28" value="12/28" class="w-full px-3 py-2 border border-zinc-300 font-mono text-xs focus:outline-none focus:border-zinc-900">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] uppercase text-zinc-500 font-semibold mb-1">CVC Code</label>
                                        <input type="text" placeholder="888" value="888" class="w-full px-3 py-2 border border-zinc-300 font-mono text-xs focus:outline-none focus:border-zinc-900">
                                    </div>
                                </div>
                            </label>

                            <!-- Option 2: Cash on Delivery -->
                            <label class="block border border-zinc-300 p-4 cursor-pointer hover:border-zinc-900 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="cod" class="text-zinc-900 focus:ring-0">
                                        <span class="text-xs font-bold text-zinc-900">White-Glove Cash on Delivery (COD)</span>
                                    </div>
                                    <i class="fa-solid fa-hand-holding-dollar text-zinc-400"></i>
                                </div>
                                <p class="text-[11px] text-zinc-500 mt-1 pl-6">
                                    Inspect your garments upon arrival and settle directly with our courier representative.
                                </p>
                            </label>

                            <!-- Option 3: Express Digital -->
                            <label class="block border border-zinc-300 p-4 cursor-pointer hover:border-zinc-900 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="express" class="text-zinc-900 focus:ring-0">
                                        <span class="text-xs font-bold text-zinc-900">Apple Pay & Google Pay Express</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-zinc-600 text-sm">
                                        <i class="fa-brands fa-apple"></i>
                                        <i class="fa-brands fa-google-pay"></i>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Complete Acquisition Button -->
                    <button type="submit" class="w-full py-4 bg-zinc-950 text-white text-xs uppercase tracking-[0.25em] font-bold hover:bg-zinc-800 transition shadow-xl">
                        Authorize & Place Acquisition &rarr;
                    </button>
                </form>
            </div>

            <!-- Order Summary & Coupons (Right) -->
            <div class="lg:col-span-5 space-y-6">

                <!-- Privilege / Promo Code -->
                <div class="bg-white p-6 border border-zinc-200">
                    <h3 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-900 mb-3">Atelier Privilege Code</h3>
                    @if($coupon)
                        <div class="p-3 bg-amber-50 border border-amber-200 flex items-center justify-between text-xs">
                            <div>
                                <span class="font-bold text-amber-900">{{ $coupon['code'] }}</span>
                                <p class="text-[11px] text-amber-700">{{ $coupon['label'] }}</p>
                            </div>
                            <form action="{{ route('checkout.coupon.remove') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs text-rose-600 hover:underline font-semibold">Remove</button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('checkout.coupon') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="code" placeholder="Enter WELCOME10 or AURELIA20" class="flex-1 px-3 py-2 border border-zinc-300 text-xs focus:outline-none focus:border-zinc-900 uppercase">
                            <button type="submit" class="px-5 py-2 bg-zinc-900 text-white text-xs uppercase tracking-wider font-semibold hover:bg-zinc-800 transition">Apply</button>
                        </form>
                        <p class="text-[10px] text-zinc-400 mt-1.5">Try "WELCOME10" for 10% off your entire order.</p>
                    @endif
                </div>

                <!-- Items Breakdown -->
                <div class="bg-white p-6 border border-zinc-200 space-y-4">
                    <h3 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-900 pb-3 border-b border-zinc-100">
                        Acquisition Summary ({{ count($cart) }} Items)
                    </h3>

                    <div class="divide-y divide-zinc-100 max-h-80 overflow-y-auto pr-1">
                        @foreach($cart as $item)
                            <div class="py-3 flex gap-3 items-center">
                                <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-14 h-18 object-cover bg-zinc-100 border border-zinc-200 flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-xs font-bold text-zinc-900 truncate font-serif-luxury">{{ $item['name'] }}</h4>
                                    <p class="text-[10px] text-zinc-500">Size: {{ $item['size'] }} &bull; Qty: {{ $item['quantity'] }}</p>
                                </div>
                                <span class="font-cinzel text-xs font-bold text-zinc-950">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-4 border-t border-zinc-200 space-y-2 text-xs">
                        <div class="flex justify-between text-zinc-600">
                            <span>Subtotal</span>
                            <span class="font-cinzel font-bold text-zinc-900">${{ number_format($subtotal, 2) }}</span>
                        </div>

                        @if($discount > 0)
                            <div class="flex justify-between text-emerald-700 font-medium">
                                <span>Privilege Discount ({{ $coupon['code'] }})</span>
                                <span>-${{ number_format($discount, 2) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between text-zinc-600">
                            <span>Express Delivery</span>
                            <span>{{ $shippingFee == 0 ? 'Complimentary' : '$' . number_format($shippingFee, 2) }}</span>
                        </div>

                        <div class="flex justify-between text-zinc-600">
                            <span>Estimated Sales Tax (8%)</span>
                            <span>${{ number_format($tax, 2) }}</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t-2 border-zinc-900 flex justify-between items-baseline">
                        <span class="text-xs uppercase tracking-wider font-bold text-zinc-950">Total Payable</span>
                        <span class="font-cinzel text-2xl font-bold text-zinc-950">${{ number_format($total, 2) }}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

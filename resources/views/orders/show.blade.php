@extends('layouts.app')

@section('title', 'Order Confirmation #' . $order->order_number . ' — AURELIA ATELIER')

@section('content')

    <div class="bg-[#FAFAFA] border-b border-zinc-200 py-12">
        <div class="max-w-4xl mx-auto px-4 text-center space-y-3">
            <div class="w-14 h-14 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-full flex items-center justify-center mx-auto text-xl shadow-xs">
                <i class="fa-solid fa-check"></i>
            </div>
            <span class="text-[10px] uppercase tracking-[0.25em] text-emerald-700 font-bold block">Acquisition Confirmed</span>
            <h1 class="font-serif-luxury text-3xl sm:text-4xl text-zinc-950 font-normal">Thank you for your patronage</h1>
            <p class="text-xs text-zinc-600 max-w-md mx-auto leading-relaxed">
                Your bespoke order has been assigned reference <span class="font-bold text-zinc-950 font-mono">#{{ $order->order_number }}</span>. An atelier confirmation dispatch has been sent to <span class="font-semibold text-zinc-900">{{ $order->customer_email }}</span>.
            </p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-12 space-y-10">

        <!-- FULFILLMENT STATUS TRACKER -->
        <div class="bg-white p-6 sm:p-8 border border-zinc-200 shadow-xs">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-zinc-100">
                <div>
                    <span class="text-[10px] uppercase tracking-[0.2em] text-zinc-400 font-semibold block">Order Status</span>
                    <h3 class="text-sm font-bold text-zinc-900 uppercase tracking-wider mt-0.5">
                        Current Stage: <span class="text-amber-800 font-serif-luxury text-base">{{ ucfirst($order->status) }}</span>
                    </h3>
                </div>
                <button type="button" onclick="window.print()" class="text-xs text-zinc-600 hover:text-zinc-900 flex items-center gap-1.5 py-1.5 px-3 border border-zinc-200">
                    <i class="fa-solid fa-print"></i> Print Receipt
                </button>
            </div>

            <!-- Stepper -->
            @php
                $statusSteps = ['pending' => 1, 'processing' => 2, 'shipped' => 3, 'delivered' => 4];
                $currentStep = $statusSteps[$order->status] ?? 2;
            @endphp
            <div class="grid grid-cols-4 gap-2 text-center text-xs">
                <div class="space-y-2">
                    <div class="w-8 h-8 rounded-full mx-auto flex items-center justify-center font-bold {{ $currentStep >= 1 ? 'bg-zinc-950 text-white' : 'bg-zinc-100 text-zinc-400' }}">1</div>
                    <p class="font-semibold text-zinc-900 text-[11px]">Placed</p>
                    <p class="text-[10px] text-zinc-400">{{ $order->created_at->format('M d, H:i') }}</p>
                </div>
                <div class="space-y-2">
                    <div class="w-8 h-8 rounded-full mx-auto flex items-center justify-center font-bold {{ $currentStep >= 2 ? 'bg-zinc-950 text-white' : 'bg-zinc-100 text-zinc-400' }}">2</div>
                    <p class="font-semibold text-zinc-900 text-[11px]">In Atelier</p>
                    <p class="text-[10px] text-zinc-400">Quality Inspection</p>
                </div>
                <div class="space-y-2">
                    <div class="w-8 h-8 rounded-full mx-auto flex items-center justify-center font-bold {{ $currentStep >= 3 ? 'bg-zinc-950 text-white' : 'bg-zinc-100 text-zinc-400' }}">3</div>
                    <p class="font-semibold text-zinc-900 text-[11px]">Dispatched</p>
                    <p class="text-[10px] text-zinc-400">Courier Transit</p>
                </div>
                <div class="space-y-2">
                    <div class="w-8 h-8 rounded-full mx-auto flex items-center justify-center font-bold {{ $currentStep >= 4 ? 'bg-emerald-600 text-white' : 'bg-zinc-100 text-zinc-400' }}">4</div>
                    <p class="font-semibold text-zinc-900 text-[11px]">Delivered</p>
                    <p class="text-[10px] text-zinc-400">White-Glove</p>
                </div>
            </div>
        </div>

        <!-- ITEMS INVOICE TABLE -->
        <div class="bg-white border border-zinc-200 overflow-hidden">
            <div class="p-6 bg-zinc-50 border-b border-zinc-200 flex items-center justify-between">
                <span class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-900">Garments in this Dispatch</span>
                <span class="text-xs text-zinc-500 font-mono">Invoice Date: {{ $order->created_at->format('M d, Y') }}</span>
            </div>

            <div class="divide-y divide-zinc-100">
                @foreach($order->items as $item)
                    <div class="p-6 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            @if($item->product_image)
                                <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}" class="w-16 h-20 object-cover bg-zinc-100 border border-zinc-200 flex-shrink-0">
                            @endif
                            <div>
                                <h4 class="text-xs sm:text-sm font-bold text-zinc-900 font-serif-luxury">{{ $item->product_name }}</h4>
                                <p class="text-[11px] text-zinc-500 mt-0.5">Size: <span class="font-semibold text-zinc-800">{{ $item->size }}</span> &bull; Shade: <span class="font-semibold text-zinc-800">{{ $item->color }}</span></p>
                                <p class="text-[11px] text-zinc-500">Qty: {{ $item->quantity }} &times; ${{ number_format($item->price, 2) }}</p>
                            </div>
                        </div>
                        <span class="font-cinzel text-sm font-bold text-zinc-950">${{ number_format($item->total, 2) }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Financial Breakdown -->
            <div class="p-6 bg-zinc-50/70 border-t border-zinc-200 space-y-2 text-xs">
                <div class="flex justify-between text-zinc-600">
                    <span>Subtotal</span>
                    <span class="font-cinzel font-semibold text-zinc-900">${{ number_format($order->subtotal, 2) }}</span>
                </div>
                @if($order->discount > 0)
                    <div class="flex justify-between text-emerald-700">
                        <span>Privilege Discount</span>
                        <span>-${{ number_format($order->discount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-zinc-600">
                    <span>Express Delivery</span>
                    <span>{{ $order->shipping_fee == 0 ? 'Complimentary ($0.00)' : '$' . number_format($order->shipping_fee, 2) }}</span>
                </div>
                <div class="flex justify-between text-zinc-600">
                    <span>Sales Tax</span>
                    <span>${{ number_format($order->tax, 2) }}</span>
                </div>
                <div class="pt-3 border-t border-zinc-300 flex justify-between items-baseline font-bold text-sm text-zinc-950">
                    <span class="uppercase tracking-wider text-xs">Total Amount Paid</span>
                    <span class="font-cinzel text-xl">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- ADDRESS & LOGISTICS SUMMARY -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
            <div class="bg-white p-6 border border-zinc-200 space-y-2">
                <span class="text-[10px] uppercase tracking-[0.2em] text-zinc-400 font-bold block mb-1">Destination</span>
                <p class="font-bold text-zinc-900 text-sm">{{ $order->customer_name }}</p>
                <p class="text-zinc-600">{{ $order->shipping_address }}</p>
                <p class="text-zinc-600">{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                <p class="text-zinc-600">{{ $order->shipping_country }}</p>
                <p class="text-zinc-500 pt-2"><i class="fa-solid fa-phone text-[10px] mr-1"></i> {{ $order->customer_phone }}</p>
            </div>

            <div class="bg-white p-6 border border-zinc-200 space-y-2">
                <span class="text-[10px] uppercase tracking-[0.2em] text-zinc-400 font-bold block mb-1">Payment & Security</span>
                <p class="text-zinc-900 font-bold capitalize">Method: {{ $order->payment_method === 'cod' ? 'Cash on Delivery (White Glove)' : 'Credit / Debit Card' }}</p>
                <p class="text-zinc-600">Payment Status: <span class="font-semibold text-emerald-700 capitalize">{{ $order->payment_status }}</span></p>
                @if($order->notes)
                    <p class="text-zinc-500 pt-2 italic">Note: "{{ $order->notes }}"</p>
                @endif
                <div class="pt-3 flex gap-2">
                    <a href="{{ route('shop.index') }}" class="px-5 py-2.5 bg-zinc-950 text-white text-[11px] uppercase tracking-wider font-semibold hover:bg-zinc-800 transition">
                        Explore Collections
                    </a>
                </div>
            </div>
        </div>

    </div>

@endsection

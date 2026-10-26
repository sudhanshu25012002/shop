@extends('layouts.app')

@section('title', 'Track Order — AURELIA ATELIER')

@section('content')

    <div class="bg-[#FAFAFA] border-b border-zinc-200 py-10">
        <div class="max-w-2xl mx-auto px-4 text-center">
            <span class="text-[10px] uppercase tracking-[0.25em] text-zinc-400 font-bold block mb-2">Concierge Logistics</span>
            <h1 class="font-serif-luxury text-3xl text-zinc-950 font-normal">Track Your Atelier Acquisition</h1>
            <p class="text-xs text-zinc-500 mt-2">Enter your order confirmation reference to view current fulfillment stage.</p>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-4 py-12">
        <!-- Search Box -->
        <div class="bg-white p-8 border border-zinc-200 shadow-sm">
            <form action="{{ route('orders.track') }}" method="GET" class="space-y-4">
                <div>
                    <label class="block text-xs uppercase tracking-wider font-bold text-zinc-800 mb-1.5">Order Reference Number</label>
                    <div class="flex gap-2">
                        <input type="text" name="order_number" required placeholder="e.g. AUR-2026-9041" value="{{ request('order_number') }}" class="flex-1 px-4 py-3 border border-zinc-300 text-xs font-mono uppercase focus:outline-none focus:border-zinc-900">
                        <button type="submit" class="px-6 py-3 bg-zinc-950 text-white text-xs uppercase tracking-wider font-semibold hover:bg-zinc-800 transition">
                            Track
                        </button>
                    </div>
                </div>
                <div class="text-[11px] text-zinc-400 flex items-center justify-between">
                    <span>Try sample order: <a href="{{ route('orders.track', ['order_number' => 'AUR-2026-9041']) }}" class="underline text-zinc-700 font-mono">AUR-2026-9041</a></span>
                    <a href="{{ route('login') }}" class="underline hover:text-zinc-700">Sign in to view all</a>
                </div>
            </form>
        </div>

        <!-- Tracking Result -->
        @if(request()->filled('order_number'))
            <div class="mt-8">
                @if($order)
                    <div class="bg-white border border-zinc-200 p-6 space-y-6">
                        <div class="flex items-center justify-between pb-4 border-b border-zinc-100">
                            <div>
                                <span class="text-[10px] uppercase tracking-[0.2em] text-zinc-400 font-semibold block">Order Reference</span>
                                <p class="font-mono text-base font-bold text-zinc-950 mt-0.5">#{{ $order->order_number }}</p>
                            </div>
                            <span class="text-xs uppercase tracking-wider font-bold px-3 py-1 border {{ $order->status_badge }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>

                        <!-- Stepper -->
                        @php
                            $statusSteps = ['pending' => 1, 'processing' => 2, 'shipped' => 3, 'delivered' => 4];
                            $currentStep = $statusSteps[$order->status] ?? 2;
                        @endphp
                        <div class="grid grid-cols-4 gap-2 text-center text-xs pt-2">
                            <div class="space-y-1">
                                <div class="w-7 h-7 rounded-full mx-auto flex items-center justify-center font-bold {{ $currentStep >= 1 ? 'bg-zinc-950 text-white' : 'bg-zinc-100 text-zinc-400' }} text-[11px]">1</div>
                                <p class="font-semibold text-zinc-900 text-[11px]">Order Placed</p>
                            </div>
                            <div class="space-y-1">
                                <div class="w-7 h-7 rounded-full mx-auto flex items-center justify-center font-bold {{ $currentStep >= 2 ? 'bg-zinc-950 text-white' : 'bg-zinc-100 text-zinc-400' }} text-[11px]">2</div>
                                <p class="font-semibold text-zinc-900 text-[11px]">Quality Check</p>
                            </div>
                            <div class="space-y-1">
                                <div class="w-7 h-7 rounded-full mx-auto flex items-center justify-center font-bold {{ $currentStep >= 3 ? 'bg-zinc-950 text-white' : 'bg-zinc-100 text-zinc-400' }} text-[11px]">3</div>
                                <p class="font-semibold text-zinc-900 text-[11px]">Courier Transit</p>
                            </div>
                            <div class="space-y-1">
                                <div class="w-7 h-7 rounded-full mx-auto flex items-center justify-center font-bold {{ $currentStep >= 4 ? 'bg-emerald-600 text-white' : 'bg-zinc-100 text-zinc-400' }} text-[11px]">4</div>
                                <p class="font-semibold text-zinc-900 text-[11px]">Delivered</p>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-zinc-100 flex items-center justify-between text-xs">
                            <span class="text-zinc-500">Destination: {{ $order->shipping_city }}, {{ $order->shipping_country }}</span>
                            <a href="{{ route('orders.show', $order->order_number) }}" class="font-bold text-zinc-950 underline">View Full Invoice &rarr;</a>
                        </div>
                    </div>
                @else
                    <div class="p-6 bg-zinc-50 border border-zinc-200 text-center text-xs text-zinc-600">
                        <i class="fa-solid fa-circle-xmark text-rose-500 text-lg mb-2"></i>
                        <p class="font-semibold">No order found with reference "{{ request('order_number') }}".</p>
                        <p class="text-zinc-400 mt-1">Please check your email confirmation or contact concierge support.</p>
                    </div>
                @endif
            </div>
        @endif
    </div>

@endsection

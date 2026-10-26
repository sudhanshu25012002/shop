@extends('layouts.admin')

@section('title', 'Order #' . $order->order_number . ' — Aurelia Studio')

@section('content')

    <div class="max-w-5xl mx-auto pb-12">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-8 border-b border-zinc-200 gap-4">
            <div>
                <a href="{{ route('admin.orders.index') }}" class="text-xs text-zinc-500 hover:text-zinc-900 flex items-center gap-1.5 mb-1">
                    &larr; Back to All Orders
                </a>
                <h1 class="font-cinzel text-2xl font-bold text-zinc-950">
                    Order Ref: <span class="font-mono">#{{ $order->order_number }}</span>
                </h1>
                <p class="text-xs text-zinc-400 mt-0.5">Placed on {{ $order->created_at->format('F d, Y \a\t H:i') }} &bull; IP Logged</p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('orders.show', $order->order_number) }}" target="_blank" class="px-3.5 py-2 bg-white border border-zinc-300 text-zinc-700 hover:text-zinc-950 text-xs font-semibold rounded flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> Client Invoice
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- Left: Order Items & Payment (8 cols) -->
            <div class="lg:col-span-8 space-y-6">

                <!-- Items Card -->
                <div class="bg-white border border-zinc-200 shadow-2xs">
                    <div class="p-6 border-b border-zinc-200 flex items-center justify-between">
                        <h2 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-950">
                            Purchased Pieces ({{ $order->items->count() }})
                        </h2>
                    </div>

                    <div class="divide-y divide-zinc-100">
                        @foreach($order->items as $item)
                            <div class="p-6 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    @if($item->product_image)
                                        <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}" class="w-14 h-18 object-cover bg-zinc-100 border border-zinc-200 flex-shrink-0">
                                    @endif
                                    <div>
                                        <h3 class="text-xs font-bold text-zinc-950 font-serif-luxury sm:text-sm">{{ $item->product_name }}</h3>
                                        <p class="text-[11px] text-zinc-500 mt-0.5">Size: <span class="font-semibold text-zinc-800">{{ $item->size }}</span> &bull; Shade: <span class="font-semibold text-zinc-800">{{ $item->color }}</span></p>
                                        <p class="text-[11px] text-zinc-400">Unit Price: ${{ number_format($item->price, 2) }} &times; {{ $item->quantity }}</p>
                                    </div>
                                </div>
                                <span class="font-cinzel text-sm font-bold text-zinc-950">${{ number_format($item->total, 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Financial Breakdown -->
                    <div class="p-6 bg-zinc-50 border-t border-zinc-200 space-y-2 text-xs">
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
                            <span>Shipping</span>
                            <span>{{ $order->shipping_fee == 0 ? 'Complimentary ($0.00)' : '$' . number_format($order->shipping_fee, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-zinc-600">
                            <span>Sales Tax</span>
                            <span>${{ number_format($order->tax, 2) }}</span>
                        </div>
                        <div class="pt-3 border-t border-zinc-300 flex justify-between items-baseline font-bold text-sm text-zinc-950">
                            <span class="uppercase tracking-wider text-xs">Total Settlement</span>
                            <span class="font-cinzel text-xl">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                @if($order->notes)
                    <div class="bg-white p-6 border border-zinc-200 shadow-2xs">
                        <h3 class="text-xs uppercase tracking-wider font-bold text-zinc-900 mb-2">Client Special Delivery Notes</h3>
                        <p class="text-xs text-zinc-600 italic bg-zinc-50 p-3 border border-zinc-100">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Right: Status Update, Destination, Client (4 cols) -->
            <div class="lg:col-span-4 space-y-6">

                <!-- Status Control Box -->
                <div class="bg-white p-6 border border-zinc-200 shadow-2xs space-y-4">
                    <h3 class="text-xs uppercase tracking-[0.18em] font-bold text-zinc-950 pb-2 border-b border-zinc-100">
                        Order Status Control
                    </h3>

                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <label class="block text-xs font-semibold text-zinc-700">Fulfillment Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-zinc-300 text-xs font-semibold rounded bg-white">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing (Quality Check)</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped (In Transit)</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="w-full py-2 bg-zinc-950 text-white text-xs font-semibold hover:bg-zinc-800 transition">
                            Update Fulfillment Status
                        </button>
                    </form>

                    <div class="pt-3 border-t border-zinc-100">
                        <form action="{{ route('admin.orders.payment-status', $order->id) }}" method="POST" class="space-y-3">
                            @csrf
                            @method('PUT')
                            <label class="block text-xs font-semibold text-zinc-700">Payment Settlement</label>
                            <select name="payment_status" class="w-full px-3 py-2 border border-zinc-300 text-xs font-semibold rounded bg-white">
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending Settlement</option>
                                <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed / Rejected</option>
                            </select>
                            <button type="submit" class="w-full py-2 bg-zinc-100 text-zinc-800 border border-zinc-300 text-xs font-semibold hover:bg-zinc-200 transition">
                                Update Payment Status
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Client Information -->
                <div class="bg-white p-6 border border-zinc-200 shadow-2xs space-y-2 text-xs">
                    <h3 class="text-xs uppercase tracking-[0.18em] font-bold text-zinc-950 pb-2 border-b border-zinc-100">
                        Client Information
                    </h3>
                    <p class="font-bold text-zinc-900 text-sm">{{ $order->customer_name }}</p>
                    <p class="text-zinc-600"><i class="fa-regular fa-envelope text-[11px] mr-1.5 text-zinc-400"></i> {{ $order->customer_email }}</p>
                    <p class="text-zinc-600"><i class="fa-solid fa-phone text-[11px] mr-1.5 text-zinc-400"></i> {{ $order->customer_phone }}</p>
                    @if($order->user)
                        <span class="inline-block mt-1 px-2 py-0.5 bg-zinc-100 text-zinc-700 text-[10px] uppercase font-bold rounded">Registered Client Member</span>
                    @else
                        <span class="inline-block mt-1 px-2 py-0.5 bg-zinc-50 text-zinc-500 text-[10px] uppercase font-medium rounded">Guest Checkout</span>
                    @endif
                </div>

                <!-- Shipping Destination -->
                <div class="bg-white p-6 border border-zinc-200 shadow-2xs space-y-2 text-xs">
                    <h3 class="text-xs uppercase tracking-[0.18em] font-bold text-zinc-950 pb-2 border-b border-zinc-100">
                        Dispatch Destination
                    </h3>
                    <p class="text-zinc-800 font-medium">{{ $order->shipping_address }}</p>
                    <p class="text-zinc-800">{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                    <p class="text-zinc-800">{{ $order->shipping_country }}</p>
                    <div class="pt-2 text-[11px] text-zinc-400">
                        White-Glove Insured Delivery
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

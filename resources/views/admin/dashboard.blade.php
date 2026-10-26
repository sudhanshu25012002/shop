@extends('layouts.admin')

@section('title', 'Atelier Studio Dashboard — Aurelia')

@section('content')

    <!-- Top Greeting & Quick Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-8 border-b border-zinc-200 gap-4">
        <div>
            <span class="text-[10px] uppercase tracking-[0.25em] text-zinc-400 font-bold block">Executive Atelier Overview</span>
            <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-zinc-950 mt-1">Management Studio</h1>
            <p class="text-xs text-zinc-500 mt-1">Live metrics, incoming orders, and inventory monitoring.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 bg-zinc-950 text-white text-xs uppercase tracking-wider font-semibold hover:bg-zinc-800 transition flex items-center gap-2 shadow-xs">
                <i class="fa-solid fa-plus text-[10px]"></i> New Product
            </a>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2.5 bg-white border border-zinc-300 text-zinc-800 text-xs uppercase tracking-wider font-semibold hover:border-zinc-950 transition">
                View All Orders
            </a>
        </div>
    </div>

    <!-- 4 KPI METRIC CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Revenue -->
        <div class="bg-white p-6 border border-zinc-200 shadow-2xs space-y-2">
            <div class="flex items-center justify-between text-zinc-400 text-xs">
                <span class="uppercase tracking-wider font-bold text-[10px]">Gross Revenue</span>
                <i class="fa-solid fa-vault text-amber-600"></i>
            </div>
            <p class="font-cinzel text-3xl font-bold text-zinc-950">${{ number_format($totalRevenue, 2) }}</p>
            <p class="text-[11px] text-emerald-600 flex items-center gap-1 font-semibold">
                <i class="fa-solid fa-arrow-trend-up text-[10px]"></i> +18.4% from last month
            </p>
        </div>

        <!-- Orders -->
        <div class="bg-white p-6 border border-zinc-200 shadow-2xs space-y-2">
            <div class="flex items-center justify-between text-zinc-400 text-xs">
                <span class="uppercase tracking-wider font-bold text-[10px]">Total Orders</span>
                <i class="fa-solid fa-bag-shopping text-zinc-600"></i>
            </div>
            <p class="font-cinzel text-3xl font-bold text-zinc-950">{{ $totalOrders }}</p>
            <p class="text-[11px] text-zinc-500">
                <span class="font-bold text-amber-700">{{ $ordersByStatus['pending'] + $ordersByStatus['processing'] }}</span> active fulfillment
            </p>
        </div>

        <!-- Products -->
        <div class="bg-white p-6 border border-zinc-200 shadow-2xs space-y-2">
            <div class="flex items-center justify-between text-zinc-400 text-xs">
                <span class="uppercase tracking-wider font-bold text-[10px]">Catalog Garments</span>
                <i class="fa-solid fa-shirt text-zinc-600"></i>
            </div>
            <p class="font-cinzel text-3xl font-bold text-zinc-950">{{ $totalProducts }}</p>
            <p class="text-[11px] text-zinc-500">
                <span class="font-bold text-emerald-700">7 Active Collections</span>
            </p>
        </div>

        <!-- Customers -->
        <div class="bg-white p-6 border border-zinc-200 shadow-2xs space-y-2">
            <div class="flex items-center justify-between text-zinc-400 text-xs">
                <span class="uppercase tracking-wider font-bold text-[10px]">Client Directory</span>
                <i class="fa-solid fa-users text-zinc-600"></i>
            </div>
            <p class="font-cinzel text-3xl font-bold text-zinc-950">{{ $totalCustomers }}</p>
            <p class="text-[11px] text-zinc-500">
                Active VIP atelier patrons
            </p>
        </div>
    </div>

    <!-- Fulfillment Status Summary Strip -->
    <div class="bg-white p-5 border border-zinc-200 mb-10 flex flex-wrap items-center justify-between gap-4 text-xs">
        <span class="font-bold uppercase tracking-wider text-[11px] text-zinc-800">Fulfillment Pipeline:</span>
        <div class="flex flex-wrap items-center gap-3">
            <span class="px-3 py-1 bg-amber-50 border border-amber-200 text-amber-900 rounded font-semibold">
                Pending: {{ $ordersByStatus['pending'] }}
            </span>
            <span class="px-3 py-1 bg-blue-50 border border-blue-200 text-blue-900 rounded font-semibold">
                Processing: {{ $ordersByStatus['processing'] }}
            </span>
            <span class="px-3 py-1 bg-indigo-50 border border-indigo-200 text-indigo-900 rounded font-semibold">
                Shipped: {{ $ordersByStatus['shipped'] }}
            </span>
            <span class="px-3 py-1 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded font-semibold">
                Delivered: {{ $ordersByStatus['delivered'] }}
            </span>
        </div>
    </div>

    <!-- MAIN TWO-COLUMN SECTION: RECENT ORDERS & INVENTORY ALERTS -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Recent Orders Table (8 cols) -->
        <div class="lg:col-span-8 bg-white border border-zinc-200">
            <div class="p-6 border-b border-zinc-200 flex items-center justify-between">
                <div>
                    <h2 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-950">Recent Client Acquisitions</h2>
                    <p class="text-[11px] text-zinc-400 mt-0.5">Most recent orders placed on the storefront.</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold text-zinc-700 hover:text-zinc-950 underline">
                    All Orders &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-zinc-50 border-b border-zinc-200 text-zinc-500 uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-3 px-6">Order Ref</th>
                            <th class="py-3 px-6">Client</th>
                            <th class="py-3 px-6">Items</th>
                            <th class="py-3 px-6">Amount</th>
                            <th class="py-3 px-6">Status</th>
                            <th class="py-3 px-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 text-zinc-700">
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-zinc-50/60 transition">
                                <td class="py-4 px-6 font-mono font-bold text-zinc-950">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="hover:underline">
                                        #{{ $order->order_number }}
                                    </a>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="font-semibold text-zinc-900">{{ $order->customer_name }}</p>
                                    <p class="text-[10px] text-zinc-400 truncate max-w-[140px]">{{ $order->customer_email }}</p>
                                </td>
                                <td class="py-4 px-6 font-medium">
                                    {{ $order->items->count() }} piece(s)
                                </td>
                                <td class="py-4 px-6 font-cinzel font-bold text-zinc-950">
                                    ${{ number_format($order->total, 2) }}
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-block px-2.5 py-0.5 text-[10px] uppercase font-bold tracking-wider rounded border {{ $order->status_badge }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-zinc-700 hover:text-zinc-950 font-bold underline">
                                        Inspect
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Low Stock Alerts & Top Pieces (4 cols) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Low Stock Box -->
            <div class="bg-white border border-zinc-200 p-6">
                <div class="flex items-center justify-between pb-3 border-b border-zinc-100 mb-4">
                    <h3 class="text-xs uppercase tracking-[0.18em] font-bold text-zinc-950 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-amber-500"></i>
                        Inventory Watchlist
                    </h3>
                    <span class="text-[10px] font-bold text-zinc-400">&le; 15 units</span>
                </div>

                <div class="space-y-3">
                    @forelse($lowStockProducts as $prod)
                        <div class="flex items-center justify-between text-xs pb-2 border-b border-zinc-50">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <img src="{{ asset($prod->image) }}" alt="{{ $prod->name }}" class="w-9 h-11 object-cover bg-zinc-100 border border-zinc-200 flex-shrink-0">
                                <div class="truncate">
                                    <a href="{{ route('admin.products.edit', $prod->id) }}" class="font-bold text-zinc-900 hover:underline block truncate">{{ $prod->name }}</a>
                                    <span class="text-[10px] text-zinc-400 font-mono">{{ $prod->sku }}</span>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[11px] font-bold font-mono {{ $prod->stock <= 5 ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-900' }}">
                                {{ $prod->stock }} left
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-zinc-400 italic">All products are healthy in inventory.</p>
                    @endforelse
                </div>
            </div>

            <!-- Atelier Top Pieces -->
            <div class="bg-white border border-zinc-200 p-6">
                <h3 class="text-xs uppercase tracking-[0.18em] font-bold text-zinc-950 pb-3 border-b border-zinc-100 mb-4">
                    Most Popular Pieces
                </h3>
                <div class="space-y-3">
                    @foreach($topProducts as $idx => $tp)
                        <div class="flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="text-[11px] font-mono font-bold text-zinc-400 w-4">{{ $idx + 1 }}.</span>
                                <span class="font-medium text-zinc-800 truncate">{{ $tp->name }}</span>
                            </div>
                            <span class="font-cinzel font-bold text-zinc-950">${{ number_format($tp->price, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

@endsection

@extends('layouts.admin')

@section('title', 'Client Orders — Aurelia Studio')

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-zinc-200 gap-4">
        <div>
            <span class="text-[10px] uppercase tracking-[0.2em] text-zinc-400 font-bold block">Fulfillment Operations</span>
            <h1 class="font-cinzel text-2xl font-bold text-zinc-950 mt-0.5">Customer Orders</h1>
        </div>
    </div>

    <!-- Status Tabs -->
    <div class="flex overflow-x-auto gap-2 pb-4 mb-4 border-b border-zinc-100 text-xs font-semibold">
        <a href="{{ route('admin.orders.index') }}" class="px-3.5 py-2 rounded transition whitespace-nowrap {{ !request('status') || request('status') === 'all' ? 'bg-zinc-950 text-white' : 'bg-white border border-zinc-200 text-zinc-700 hover:bg-zinc-50' }}">
            All ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-3.5 py-2 rounded transition whitespace-nowrap {{ request('status') === 'pending' ? 'bg-amber-800 text-white' : 'bg-white border border-zinc-200 text-zinc-700 hover:bg-zinc-50' }}">
            Pending ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="px-3.5 py-2 rounded transition whitespace-nowrap {{ request('status') === 'processing' ? 'bg-blue-800 text-white' : 'bg-white border border-zinc-200 text-zinc-700 hover:bg-zinc-50' }}">
            Processing ({{ $counts['processing'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="px-3.5 py-2 rounded transition whitespace-nowrap {{ request('status') === 'shipped' ? 'bg-indigo-800 text-white' : 'bg-white border border-zinc-200 text-zinc-700 hover:bg-zinc-50' }}">
            Shipped ({{ $counts['shipped'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="px-3.5 py-2 rounded transition whitespace-nowrap {{ request('status') === 'delivered' ? 'bg-emerald-800 text-white' : 'bg-white border border-zinc-200 text-zinc-700 hover:bg-zinc-50' }}">
            Delivered ({{ $counts['delivered'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="px-3.5 py-2 rounded transition whitespace-nowrap {{ request('status') === 'cancelled' ? 'bg-rose-800 text-white' : 'bg-white border border-zinc-200 text-zinc-700 hover:bg-zinc-50' }}">
            Cancelled ({{ $counts['cancelled'] }})
        </a>
    </div>

    <!-- Search Toolbar -->
    <div class="bg-white p-4 border border-zinc-200 mb-6">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex gap-3 text-xs">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by order reference (#AUR-...) or client name/email..." class="flex-1 px-3.5 py-2 border border-zinc-300 focus:outline-none focus:border-zinc-900">
            <button type="submit" class="px-6 py-2 bg-zinc-900 text-white font-semibold hover:bg-zinc-800 transition">Search</button>
            @if(request('q'))
                <a href="{{ route('admin.orders.index', request()->except('q')) }}" class="px-3 py-2 bg-zinc-100 hover:bg-zinc-200 text-zinc-700 flex items-center justify-center">Reset</a>
            @endif
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white border border-zinc-200 overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-zinc-50 border-b border-zinc-200 text-zinc-500 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3.5 px-6">Order Ref</th>
                        <th class="py-3.5 px-4">Client</th>
                        <th class="py-3.5 px-4">Destination</th>
                        <th class="py-3.5 px-4">Items</th>
                        <th class="py-3.5 px-4">Total Amount</th>
                        <th class="py-3.5 px-4">Payment</th>
                        <th class="py-3.5 px-4">Status & Update</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 text-zinc-700">
                    @forelse($orders as $order)
                        <tr class="hover:bg-zinc-50/60 transition">
                            <td class="py-4 px-6 font-mono font-bold text-zinc-950">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="hover:underline">
                                    #{{ $order->order_number }}
                                </a>
                                <span class="block text-[10px] text-zinc-400 font-sans font-normal">{{ $order->created_at->format('M d, H:i') }}</span>
                            </td>

                            <td class="py-4 px-4">
                                <p class="font-bold text-zinc-900">{{ $order->customer_name }}</p>
                                <p class="text-[10px] text-zinc-400 truncate max-w-[150px]">{{ $order->customer_email }}</p>
                            </td>

                            <td class="py-4 px-4 text-zinc-600">
                                {{ $order->shipping_city }}, {{ $order->shipping_country }}
                            </td>

                            <td class="py-4 px-4 font-semibold text-zinc-800">
                                {{ $order->items->count() }} piece(s)
                            </td>

                            <td class="py-4 px-4 font-cinzel font-bold text-zinc-950">
                                ${{ number_format($order->total, 2) }}
                            </td>

                            <td class="py-4 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold tracking-wider {{ $order->payment_status === 'paid' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }}">
                                    {{ $order->payment_status }}
                                </span>
                            </td>

                            <!-- Instant Status Change Form -->
                            <td class="py-4 px-4">
                                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="text-xs py-1 px-2 border rounded font-semibold focus:outline-none {{ $order->status_badge }}">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="px-3 py-1.5 bg-zinc-100 hover:bg-zinc-200 text-zinc-900 rounded font-semibold text-xs inline-block">
                                    Details &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-zinc-400">
                                No orders found matching filter criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-zinc-200">
            {{ $orders->links() }}
        </div>
    </div>

@endsection

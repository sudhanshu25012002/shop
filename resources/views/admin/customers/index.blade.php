@extends('layouts.admin')

@section('title', 'Client Directory — Aurelia Studio')

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-zinc-200 gap-4">
        <div>
            <span class="text-[10px] uppercase tracking-[0.2em] text-zinc-400 font-bold block">Client Relations</span>
            <h1 class="font-cinzel text-2xl font-bold text-zinc-950 mt-0.5">VIP Client Directory</h1>
        </div>
    </div>

    <!-- Search Box -->
    <div class="bg-white p-4 border border-zinc-200 mb-6">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="flex gap-3 text-xs">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by client name, email, or telephone..." class="flex-1 px-3.5 py-2 border border-zinc-300 focus:outline-none focus:border-zinc-900">
            <button type="submit" class="px-6 py-2 bg-zinc-900 text-white font-semibold hover:bg-zinc-800 transition">Search Clients</button>
            @if(request('q'))
                <a href="{{ route('admin.customers.index') }}" class="px-3 py-2 bg-zinc-100 hover:bg-zinc-200 text-zinc-700 flex items-center justify-center">Reset</a>
            @endif
        </form>
    </div>

    <!-- Customers Table -->
    <div class="bg-white border border-zinc-200 overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-zinc-50 border-b border-zinc-200 text-zinc-500 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3.5 px-6">Client Name</th>
                        <th class="py-3.5 px-4">Contact</th>
                        <th class="py-3.5 px-4">Residence</th>
                        <th class="py-3.5 px-4">Acquisitions</th>
                        <th class="py-3.5 px-4">Lifetime Spend</th>
                        <th class="py-3.5 px-4">Client Tier</th>
                        <th class="py-3.5 px-6 text-right">Registered</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 text-zinc-700">
                    @forelse($customers as $cust)
                        <tr class="hover:bg-zinc-50/60 transition">
                            <td class="py-4 px-6 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-zinc-950 text-amber-300 font-bold flex items-center justify-center text-xs flex-shrink-0">
                                    {{ strtoupper(substr($cust->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-zinc-900">{{ $cust->name }}</p>
                                    <span class="text-[10px] text-zinc-400 font-mono">ID: AUR-USR-{{ $cust->id }}</span>
                                </div>
                            </td>

                            <td class="py-4 px-4">
                                <p class="text-zinc-800 font-medium">{{ $cust->email }}</p>
                                <p class="text-[11px] text-zinc-400">{{ $cust->phone ?: 'Not registered' }}</p>
                            </td>

                            <td class="py-4 px-4 text-zinc-600">
                                {{ $cust->city ?: 'New York' }}, {{ $cust->country ?: 'United States' }}
                            </td>

                            <td class="py-4 px-4 font-bold text-zinc-900">
                                {{ $cust->orders_count }} orders
                            </td>

                            <td class="py-4 px-4 font-cinzel font-bold text-zinc-950">
                                ${{ number_format($cust->orders_sum_total ?: 0, 2) }}
                            </td>

                            <td class="py-4 px-4">
                                @if(($cust->orders_sum_total ?? 0) >= 1000)
                                    <span class="px-2.5 py-0.5 rounded text-[10px] uppercase font-bold tracking-wider bg-amber-50 text-amber-900 border border-amber-200">
                                        ★ Haute VIP
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded text-[10px] uppercase font-bold tracking-wider bg-zinc-100 text-zinc-700">
                                        Client Member
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-right text-zinc-400 font-mono text-[11px]">
                                {{ $cust->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-zinc-400">
                                No registered client members found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-zinc-200">
            {{ $customers->links() }}
        </div>
    </div>

@endsection

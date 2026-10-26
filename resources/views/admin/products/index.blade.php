@extends('layouts.admin')

@section('title', 'Manage Products — Aurelia Studio')

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-zinc-200 gap-4">
        <div>
            <span class="text-[10px] uppercase tracking-[0.2em] text-zinc-400 font-bold block">Inventory & Garments</span>
            <h1 class="font-cinzel text-2xl font-bold text-zinc-950 mt-0.5">Product Catalog</h1>
        </div>
        <a href="{{ route('admin.products.create') }}" class="px-5 py-2.5 bg-zinc-950 text-white text-xs uppercase tracking-wider font-semibold hover:bg-zinc-800 transition flex items-center gap-2 shadow-xs">
            <i class="fa-solid fa-plus text-[10px]"></i> Add New Piece
        </a>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="bg-white p-4 border border-zinc-200 mb-6">
        <form action="{{ route('admin.products.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 text-xs">
            <div class="sm:col-span-5">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by piece title or SKU..." class="w-full px-3.5 py-2 border border-zinc-300 focus:outline-none focus:border-zinc-900">
            </div>

            <div class="sm:col-span-3">
                <select name="category_id" class="w-full px-3 py-2 border border-zinc-300 focus:outline-none focus:border-zinc-900 bg-white">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2">
                <select name="stock_status" class="w-full px-3 py-2 border border-zinc-300 focus:outline-none focus:border-zinc-900 bg-white">
                    <option value="">All Stock Levels</option>
                    <option value="low" {{ request('stock_status') === 'low' ? 'selected' : '' }}>Low Stock (&le; 15)</option>
                    <option value="out" {{ request('stock_status') === 'out' ? 'selected' : '' }}>Sold Out</option>
                </select>
            </div>

            <div class="sm:col-span-2 flex gap-2">
                <button type="submit" class="w-full py-2 bg-zinc-900 text-white font-semibold hover:bg-zinc-800 transition">Filter</button>
                @if(request()->anyFilled(['q', 'category_id', 'stock_status']))
                    <a href="{{ route('admin.products.index') }}" class="px-3 py-2 bg-zinc-100 hover:bg-zinc-200 text-zinc-700 flex items-center justify-center" title="Reset">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white border border-zinc-200 overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-zinc-50 border-b border-zinc-200 text-zinc-500 uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3.5 px-6">Garment Piece</th>
                        <th class="py-3.5 px-4">Category</th>
                        <th class="py-3.5 px-4">Price</th>
                        <th class="py-3.5 px-4">Inventory</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-center">Featured</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 text-zinc-700">
                    @forelse($products as $product)
                        <tr class="hover:bg-zinc-50/60 transition">
                            <!-- Thumbnail & Title -->
                            <td class="py-4 px-6 flex items-center gap-3">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-12 h-15 object-cover bg-zinc-100 border border-zinc-200 flex-shrink-0">
                                <div>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="font-bold text-zinc-950 font-serif-luxury hover:underline text-sm block">
                                        {{ $product->name }}
                                    </a>
                                    <span class="text-[10px] text-zinc-400 font-mono">SKU: {{ $product->sku }}</span>
                                </div>
                            </td>

                            <!-- Category -->
                            <td class="py-4 px-4 font-medium text-zinc-600">
                                {{ $product->category->name ?? 'None' }}
                            </td>

                            <!-- Price -->
                            <td class="py-4 px-4">
                                <span class="font-cinzel font-bold text-zinc-950">${{ number_format($product->price, 2) }}</span>
                                @if($product->compare_at_price)
                                    <span class="block text-[10px] text-zinc-400 line-through">${{ number_format($product->compare_at_price, 2) }}</span>
                                @endif
                            </td>

                            <!-- Stock -->
                            <td class="py-4 px-4">
                                <span class="inline-block px-2.5 py-0.5 rounded text-[11px] font-mono font-bold {{ $product->stock <= 5 ? 'bg-rose-100 text-rose-800' : ($product->stock <= 15 ? 'bg-amber-100 text-amber-900' : 'bg-emerald-50 text-emerald-800') }}">
                                    {{ $product->stock }} in stock
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-4">
                                <span class="px-2 py-0.5 text-[10px] uppercase font-bold tracking-wider rounded {{ $product->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-zinc-100 text-zinc-600' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>

                            <!-- Featured Toggle -->
                            <td class="py-4 px-4 text-center">
                                <form action="{{ route('admin.products.toggle-featured', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-base transition {{ $product->is_featured ? 'text-amber-500' : 'text-zinc-300 hover:text-amber-400' }}" title="Toggle Featured">
                                        <i class="fa-solid fa-star"></i>
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('shop.show', $product->slug) }}" target="_blank" class="text-zinc-400 hover:text-zinc-900" title="View in storefront">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-zinc-700 hover:text-zinc-950 font-bold underline" title="Edit piece">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this piece?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-zinc-400 hover:text-rose-600 transition" title="Delete">
                                            <i class="fa-regular fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-zinc-400">
                                No products found matching criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-zinc-200">
            {{ $products->links() }}
        </div>
    </div>

@endsection

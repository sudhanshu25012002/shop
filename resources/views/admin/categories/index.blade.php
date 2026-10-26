@extends('layouts.admin')

@section('title', 'Manage Collections — Aurelia Studio')

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-zinc-200 gap-4">
        <div>
            <span class="text-[10px] uppercase tracking-[0.2em] text-zinc-400 font-bold block">Taxonomy & Groupings</span>
            <h1 class="font-cinzel text-2xl font-bold text-zinc-950 mt-0.5">Wardrobe Collections</h1>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Add Category Form (4 cols) -->
        <div class="lg:col-span-4">
            <div class="bg-white p-6 border border-zinc-200 shadow-2xs space-y-4">
                <h2 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-950 pb-2 border-b border-zinc-100">
                    Create New Category
                </h2>

                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Category Title *</label>
                        <input type="text" name="name" required placeholder="e.g. Resort & Linen" class="w-full px-3 py-2 border border-zinc-300 focus:outline-none focus:border-zinc-900 font-medium">
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Description</label>
                        <textarea name="description" rows="3" placeholder="Brief editorial introduction to this wardrobe line..." class="w-full px-3 py-2 border border-zinc-300 focus:outline-none focus:border-zinc-900"></textarea>
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Image URL / Path</label>
                        <input type="text" name="image" value="/images/products/linen_wide_trousers.jpg" class="w-full px-3 py-2 border border-zinc-300 focus:outline-none focus:border-zinc-900">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-semibold text-zinc-700 mb-1">Sort Order</label>
                            <input type="number" name="sort_order" value="10" class="w-full px-3 py-2 border border-zinc-300 focus:outline-none focus:border-zinc-900 font-mono">
                        </div>
                        <div class="flex items-center pt-5">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_featured" value="1" checked class="rounded border-zinc-300 text-zinc-900">
                                <span class="font-semibold text-zinc-800">Featured</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 bg-zinc-950 text-white text-xs uppercase tracking-wider font-bold hover:bg-zinc-800 transition">
                        Add Category
                    </button>
                </form>
            </div>
        </div>

        <!-- Categories Table (8 cols) -->
        <div class="lg:col-span-8 bg-white border border-zinc-200 shadow-2xs">
            <div class="p-6 border-b border-zinc-200 flex items-center justify-between">
                <h2 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-950">Active Categories ({{ $categories->count() }})</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-zinc-50 border-b border-zinc-200 text-zinc-500 uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-3 px-6">Collection</th>
                            <th class="py-3 px-4">Slug</th>
                            <th class="py-3 px-4">Pieces Count</th>
                            <th class="py-3 px-4">Sort Order</th>
                            <th class="py-3 px-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 text-zinc-700">
                        @foreach($categories as $category)
                            <tr class="hover:bg-zinc-50/60 transition">
                                <td class="py-4 px-6 flex items-center gap-3">
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="w-10 h-12 object-cover bg-zinc-100 border border-zinc-200 flex-shrink-0">
                                    <div>
                                        <p class="font-bold text-zinc-900">{{ $category->name }}</p>
                                        <p class="text-[10px] text-zinc-400 truncate max-w-xs">{{ $category->description }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-4 font-mono text-[11px] text-zinc-500">
                                    {{ $category->slug }}
                                </td>
                                <td class="py-4 px-4 font-bold text-zinc-900">
                                    {{ $category->products_count }} garments
                                </td>
                                <td class="py-4 px-4 font-mono">
                                    {{ $category->sort_order }}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category? Associated products may be affected.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-zinc-400 hover:text-rose-600 transition" title="Delete">
                                            <i class="fa-regular fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection

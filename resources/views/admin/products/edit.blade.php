@extends('layouts.admin')

@section('title', 'Edit Piece: ' . $product->name . ' — Aurelia Studio')

@section('content')

    <div class="max-w-4xl mx-auto pb-12">
        <div class="flex items-center justify-between pb-6 mb-8 border-b border-zinc-200">
            <div>
                <a href="{{ route('admin.products.index') }}" class="text-xs text-zinc-500 hover:text-zinc-900 flex items-center gap-1.5 mb-1">
                    &larr; Back to Products
                </a>
                <h1 class="font-cinzel text-2xl font-bold text-zinc-950">Edit Garment Piece</h1>
                <p class="text-xs text-zinc-400 font-mono mt-0.5">SKU: {{ $product->sku }}</p>
            </div>
            <a href="{{ route('shop.show', $product->slug) }}" target="_blank" class="text-xs text-zinc-700 hover:text-zinc-950 underline flex items-center gap-1 font-semibold">
                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> View in Storefront
            </a>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- 1. Essential Information -->
            <div class="bg-white p-6 border border-zinc-200 shadow-2xs space-y-4">
                <h2 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-900 pb-2 border-b border-zinc-100">
                    Garment Details
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="sm:col-span-2">
                        <label class="block font-semibold text-zinc-700 mb-1">Piece Title *</label>
                        <input type="text" name="name" required value="{{ old('name', $product->name) }}" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 font-medium">
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Collection Category *</label>
                        <select name="category_id" required class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 bg-white font-medium">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">SKU Reference</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 uppercase font-mono">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block font-semibold text-zinc-700 mb-1">Editorial Tagline</label>
                        <input type="text" name="tagline" value="{{ old('tagline', $product->tagline) }}" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900">
                    </div>
                </div>
            </div>

            <!-- 2. Pricing & Inventory -->
            <div class="bg-white p-6 border border-zinc-200 shadow-2xs space-y-4">
                <h2 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-900 pb-2 border-b border-zinc-100">
                    Pricing & Stock Control
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Retail Price ($ USD) *</label>
                        <input type="number" step="0.01" name="price" required value="{{ old('price', $product->price) }}" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 font-mono font-bold">
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Compare-at Price ($ USD)</label>
                        <input type="number" step="0.01" name="compare_at_price" value="{{ old('compare_at_price', $product->compare_at_price) }}" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 font-mono">
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Inventory Quantity *</label>
                        <input type="number" name="stock" required value="{{ old('stock', $product->stock) }}" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 font-mono font-bold">
                    </div>
                </div>
            </div>

            <!-- 3. Descriptions & Materials -->
            <div class="bg-white p-6 border border-zinc-200 shadow-2xs space-y-4">
                <h2 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-900 pb-2 border-b border-zinc-100">
                    Descriptions & Craftsmanship
                </h2>

                <div class="space-y-4 text-xs">
                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Product Description *</label>
                        <textarea name="description" rows="4" required class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Materials, Fiber Provenance & Care</label>
                        <textarea name="material_care" rows="2" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900">{{ old('material_care', $product->material_care) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- 4. Variants: Sizes & Shades -->
            <div class="bg-white p-6 border border-zinc-200 shadow-2xs space-y-4">
                <h2 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-900 pb-2 border-b border-zinc-100">
                    Variants (Sizes & Shades)
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Available Sizes (Comma-separated)</label>
                        <input type="text" name="sizes" value="{{ old('sizes', is_array($product->available_sizes) ? implode(', ', $product->available_sizes) : '') }}" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900">
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Available Shades (Comma-separated)</label>
                        @php
                            $colorNames = [];
                            if (is_array($product->available_colors)) {
                                foreach ($product->available_colors as $c) {
                                    $colorNames[] = is_array($c) ? ($c['name'] ?? '') : $c;
                                }
                            }
                        @endphp
                        <input type="text" name="colors" value="{{ old('colors', implode(', ', $colorNames)) }}" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900">
                    </div>
                </div>
            </div>

            <!-- 5. Imagery & Visibility -->
            <div class="bg-white p-6 border border-zinc-200 shadow-2xs space-y-4">
                <h2 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-900 pb-2 border-b border-zinc-100">
                    Imagery & Visibility
                </h2>

                <div class="flex items-center gap-4 mb-4">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-16 h-20 object-cover bg-zinc-100 border border-zinc-200">
                    <div>
                        <p class="text-xs font-bold text-zinc-800">Current Piece Photograph</p>
                        <p class="text-[11px] text-zinc-400 font-mono">{{ $product->image }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Replace Image (JPEG/PNG)</label>
                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-zinc-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200">
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Or Image Path / URL</label>
                        <input type="text" name="image_url" value="{{ old('image_url', $product->image) }}" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900">
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Catalog Status</label>
                        <select name="status" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 bg-white">
                            <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active (Visible in Store)</option>
                            <option value="draft" {{ $product->status === 'draft' ? 'selected' : '' }}>Draft (Private)</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-6 pt-5">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="rounded border-zinc-300 text-zinc-900">
                            <span class="font-semibold text-zinc-800">Featured</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_new" value="1" {{ $product->is_new ? 'checked' : '' }} class="rounded border-zinc-300 text-zinc-900">
                            <span class="font-semibold text-zinc-800">New Release</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_bestseller" value="1" {{ $product->is_bestseller ? 'checked' : '' }} class="rounded border-zinc-300 text-zinc-900">
                            <span class="font-semibold text-zinc-800">Bestseller</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ route('admin.products.index') }}" class="px-6 py-3 border border-zinc-300 text-zinc-700 text-xs uppercase tracking-wider font-semibold hover:bg-zinc-100 transition">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 bg-zinc-950 text-white text-xs uppercase tracking-[0.2em] font-bold hover:bg-zinc-800 transition shadow-md">
                    Update Garment Piece &rarr;
                </button>
            </div>
        </form>
    </div>

@endsection

@extends('layouts.admin')

@section('title', 'Add New Garment Piece — Aurelia Studio')

@section('content')

    <div class="max-w-4xl mx-auto pb-12">
        <div class="flex items-center justify-between pb-6 mb-8 border-b border-zinc-200">
            <div>
                <a href="{{ route('admin.products.index') }}" class="text-xs text-zinc-500 hover:text-zinc-900 flex items-center gap-1.5 mb-1">
                    &larr; Back to Products
                </a>
                <h1 class="font-cinzel text-2xl font-bold text-zinc-950">Add New Garment Piece</h1>
            </div>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- 1. Essential Information -->
            <div class="bg-white p-6 border border-zinc-200 shadow-2xs space-y-4">
                <h2 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-900 pb-2 border-b border-zinc-100">
                    Garment Details
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="sm:col-span-2">
                        <label class="block font-semibold text-zinc-700 mb-1">Piece Title *</label>
                        <input type="text" name="name" required value="{{ old('name') }}" placeholder="e.g. The Milan Double-Breasted Cashmere Trench" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 font-medium">
                        @error('name') <p class="text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Collection Category *</label>
                        <select name="category_id" required class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 bg-white font-medium">
                            <option value="">Select Category...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">SKU Reference (Optional, auto-generated)</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" placeholder="AUR-COT-099" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 uppercase font-mono">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block font-semibold text-zinc-700 mb-1">Editorial Tagline</label>
                        <input type="text" name="tagline" value="{{ old('tagline') }}" placeholder="e.g. 100% Mongolian Cashmere • Hand-finished in Tuscany" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900">
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
                        <input type="number" step="0.01" name="price" required value="{{ old('price') }}" placeholder="750.00" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 font-mono font-bold">
                        @error('price') <p class="text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Compare-at Price ($ USD, Strikethrough)</label>
                        <input type="number" step="0.01" name="compare_at_price" value="{{ old('compare_at_price') }}" placeholder="950.00" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 font-mono">
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Inventory Quantity *</label>
                        <input type="number" name="stock" required value="{{ old('stock', 15) }}" placeholder="15" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 font-mono font-bold">
                        @error('stock') <p class="text-rose-600 mt-1">{{ $message }}</p> @enderror
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
                        <textarea name="description" rows="4" required placeholder="Detailed description of the silhouette, drape, and styling notes..." class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Materials, Fiber Provenance & Care</label>
                        <textarea name="material_care" rows="2" placeholder="e.g. 100% Super 130s Virgin Wool. Hand wash cold or dry clean." class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900">{{ old('material_care') }}</textarea>
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
                        <input type="text" name="sizes" value="{{ old('sizes', 'XS, S, M, L, XL') }}" placeholder="XS, S, M, L, XL" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900">
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Available Shades (Comma-separated)</label>
                        <input type="text" name="colors" value="{{ old('colors', 'Ivory White, Chalk Ecru, Obsidian') }}" placeholder="Ivory White, Chalk Ecru, Obsidian" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900">
                    </div>
                </div>
            </div>

            <!-- 5. Imagery & Visibility -->
            <div class="bg-white p-6 border border-zinc-200 shadow-2xs space-y-4">
                <h2 class="text-xs uppercase tracking-[0.2em] font-bold text-zinc-900 pb-2 border-b border-zinc-100">
                    Imagery & Merchandising
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Upload Product Photograph (JPEG/PNG)</label>
                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-zinc-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200">
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Or Existing Image Path</label>
                        <input type="text" name="image_url" value="{{ old('image_url', '/images/products/cashmere_wool_coat.jpg') }}" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900">
                    </div>

                    <div>
                        <label class="block font-semibold text-zinc-700 mb-1">Catalog Status</label>
                        <select name="status" class="w-full px-3.5 py-2.5 border border-zinc-300 focus:outline-none focus:border-zinc-900 bg-white">
                            <option value="active">Active (Visible in Store)</option>
                            <option value="draft">Draft (Private)</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-6 pt-5">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" checked class="rounded border-zinc-300 text-zinc-900">
                            <span class="font-semibold text-zinc-800">Featured</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_new" value="1" checked class="rounded border-zinc-300 text-zinc-900">
                            <span class="font-semibold text-zinc-800">New Release</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_bestseller" value="1" class="rounded border-zinc-300 text-zinc-900">
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
                    Publish Garment Piece &rarr;
                </button>
            </div>
        </form>
    </div>

@endsection

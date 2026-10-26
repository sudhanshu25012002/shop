<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->latest();

        if ($request->filled('q')) {
            $s = $request->q;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('sku', 'like', "%{$s}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'low') {
                $query->where('stock', '<=', 15);
            } elseif ($request->stock_status === 'out') {
                $query->where('stock', '<=', 0);
            }
        }

        $products = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'sku' => 'nullable|string|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'material_care' => 'nullable|string',
            'sizes' => 'nullable|string', // comma-separated e.g. "XS, S, M, L, XL"
            'colors' => 'nullable|string', // comma-separated e.g. "Pure White, Bone, Noir"
            'image_file' => 'nullable|image|max:4096',
            'image_url' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
            'is_bestseller' => 'boolean',
            'status' => 'required|in:active,draft',
        ]);

        $imagePath = '/images/products/cashmere_wool_coat.jpg'; // default luxury fallback
        if ($request->hasFile('image_file')) {
            $filename = time() . '_' . Str::slug($request->name) . '.' . $request->file('image_file')->getClientOriginalExtension();
            $request->file('image_file')->move(public_path('images/products'), $filename);
            $imagePath = '/images/products/' . $filename;
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        // Process sizes array
        $sizesArray = ['XS', 'S', 'M', 'L'];
        if ($request->filled('sizes')) {
            $sizesArray = array_values(array_filter(array_map('trim', explode(',', $request->sizes))));
        }

        // Process colors array
        $colorsArray = [['name' => 'Alabaster White', 'hex' => '#FFFFFF']];
        if ($request->filled('colors')) {
            $colorNames = array_filter(array_map('trim', explode(',', $request->colors)));
            $colorsArray = [];
            foreach ($colorNames as $c) {
                $colorsArray[] = ['name' => $c, 'hex' => '#F4EFEA'];
            }
        }

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . rand(100, 999),
            'tagline' => $validated['tagline'],
            'sku' => $validated['sku'] ?: ('AUR-' . strtoupper(Str::random(6))),
            'price' => $validated['price'],
            'compare_at_price' => $validated['compare_at_price'],
            'stock' => $validated['stock'],
            'description' => $validated['description'],
            'material_care' => $validated['material_care'],
            'available_sizes' => $sizesArray,
            'available_colors' => $colorsArray,
            'image' => $imagePath,
            'gallery' => [$imagePath],
            'is_featured' => $request->boolean('is_featured'),
            'is_new' => $request->boolean('is_new'),
            'is_bestseller' => $request->boolean('is_bestseller'),
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.products.index')->with('success', "Product '{$product->name}' created successfully.");
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'material_care' => 'nullable|string',
            'sizes' => 'nullable|string',
            'colors' => 'nullable|string',
            'image_file' => 'nullable|image|max:4096',
            'image_url' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
            'is_bestseller' => 'boolean',
            'status' => 'required|in:active,draft',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image_file')) {
            $filename = time() . '_' . Str::slug($request->name) . '.' . $request->file('image_file')->getClientOriginalExtension();
            $request->file('image_file')->move(public_path('images/products'), $filename);
            $imagePath = '/images/products/' . $filename;
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        $sizesArray = $product->available_sizes;
        if ($request->filled('sizes')) {
            $sizesArray = array_values(array_filter(array_map('trim', explode(',', $request->sizes))));
        }

        $colorsArray = $product->available_colors;
        if ($request->filled('colors')) {
            $colorNames = array_filter(array_map('trim', explode(',', $request->colors)));
            $colorsArray = [];
            foreach ($colorNames as $c) {
                $colorsArray[] = ['name' => $c, 'hex' => '#F4EFEA'];
            }
        }

        $product->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'tagline' => $validated['tagline'],
            'sku' => $validated['sku'] ?: $product->sku,
            'price' => $validated['price'],
            'compare_at_price' => $validated['compare_at_price'],
            'stock' => $validated['stock'],
            'description' => $validated['description'],
            'material_care' => $validated['material_care'],
            'available_sizes' => $sizesArray,
            'available_colors' => $colorsArray,
            'image' => $imagePath,
            'is_featured' => $request->boolean('is_featured'),
            'is_new' => $request->boolean('is_new'),
            'is_bestseller' => $request->boolean('is_bestseller'),
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.products.index')->with('success', "Product '{$product->name}' updated successfully.");
    }

    public function destroy(Product $product)
    {
        $name = $product->name;
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', "Product '{$name}' was deleted.");
    }

    public function toggleFeatured(Product $product)
    {
        $product->is_featured = !$product->is_featured;
        $product->save();
        return redirect()->back()->with('success', "Product featured status updated.");
    }
}

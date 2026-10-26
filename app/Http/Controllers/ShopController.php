<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('status', 'active');

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search filter
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('tagline', 'like', "%{$search}%");
            });
        }

        // Price filters
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->max_price);
        }

        // Stock filter
        if ($request->boolean('in_stock')) {
            $query->where('stock', '>', 0);
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'bestseller':
                $query->orderBy('is_bestseller', 'desc')->orderBy('created_at', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();
        $selectedCategory = $request->filled('category') ? Category::where('slug', $request->category)->first() : null;

        return view('shop.index', compact('products', 'categories', 'selectedCategory', 'sort'));
    }

    public function show(string $slug)
    {
        $product = Product::with(['category', 'reviews'])->where('slug', $slug)->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }

    public function quickView(Product $product)
    {
        $product->load('category');
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'category' => $product->category->name ?? 'Collection',
            'tagline' => $product->tagline,
            'price' => number_format($product->price, 2),
            'compare_at_price' => $product->compare_at_price ? number_format($product->compare_at_price, 2) : null,
            'discount' => $product->discountPercentage(),
            'description' => $product->description,
            'image' => asset($product->image),
            'stock' => $product->stock,
            'in_stock' => $product->inStock(),
            'sizes' => $product->available_sizes ?: ['XS', 'S', 'M', 'L'],
            'colors' => $product->available_colors ?: [['name' => 'Alabaster White', 'hex' => '#FFFFFF']],
            'url' => route('shop.show', $product->slug),
        ]);
    }
}

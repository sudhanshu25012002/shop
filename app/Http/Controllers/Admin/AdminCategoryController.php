<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('sort_order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ]);

        Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'image' => $validated['image'] ?: '/images/products/cashmere_wool_coat.jpg',
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.categories.index')->with('success', "Category '{$validated['name']}' created successfully.");
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'image' => $validated['image'] ?: $category->image,
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => $validated['sort_order'] ?? $category->sort_order,
        ]);

        return redirect()->route('admin.categories.index')->with('success', "Category '{$category->name}' updated.");
    }

    public function destroy(Category $category)
    {
        $name = $category->name;
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', "Category '{$name}' deleted.");
    }
}

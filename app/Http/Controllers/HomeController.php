<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCategories = Category::where('is_featured', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $featuredProducts = Product::with('category')
            ->where('status', 'active')
            ->where('is_featured', true)
            ->take(8)
            ->get();

        $newArrivals = Product::with('category')
            ->where('status', 'active')
            ->where('is_new', true)
            ->take(4)
            ->get();

        $bestsellers = Product::with('category')
            ->where('status', 'active')
            ->where('is_bestseller', true)
            ->take(4)
            ->get();

        return view('home', compact(
            'featuredCategories',
            'featuredProducts',
            'newArrivals',
            'bestsellers'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = $this->calculateSubtotal($cart);
        $freeShippingThreshold = 150.00;
        $shippingNeeded = max(0, $freeShippingThreshold - $subtotal);
        $shippingProgress = min(100, round(($subtotal / $freeShippingThreshold) * 100));

        return view('cart.index', compact('cart', 'subtotal', 'freeShippingThreshold', 'shippingNeeded', 'shippingProgress'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:10',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = (int) ($request->quantity ?: 1);
        $size = $request->size ?: ($product->available_sizes[0] ?? 'Regular');
        $color = $request->color ?: (is_array($product->available_colors[0] ?? null) ? $product->available_colors[0]['name'] : 'White');

        $cart = session()->get('cart', []);
        $itemKey = md5($product->id . '_' . $size . '_' . $color);

        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['quantity'] += $quantity;
        } else {
            $cart[$itemKey] = [
                'key' => $itemKey,
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => (float) $product->price,
                'image' => $product->image,
                'size' => $size,
                'color' => $color,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Added to your shopping bag.',
                'cartCount' => $this->calculateCount($cart),
                'subtotal' => number_format($this->calculateSubtotal($cart), 2),
                'cart' => array_values($cart),
            ]);
        }

        return redirect()->back()->with('success', "{$product->name} added to your bag.");
    }

    public function update(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'quantity' => 'required|integer|min:1|max:20',
        ]);

        $cart = session()->get('cart', []);
        $key = $request->key;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = (int) $request->quantity;
            session()->put('cart', $cart);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'cartCount' => $this->calculateCount($cart),
                'subtotal' => number_format($this->calculateSubtotal($cart), 2),
                'itemTotal' => isset($cart[$key]) ? number_format($cart[$key]['price'] * $cart[$key]['quantity'], 2) : 0,
            ]);
        }

        return redirect()->back()->with('success', 'Shopping bag updated.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        $key = $request->key;

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from bag.',
                'cartCount' => $this->calculateCount($cart),
                'subtotal' => number_format($this->calculateSubtotal($cart), 2),
            ]);
        }

        return redirect()->back()->with('success', 'Item removed from your bag.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Shopping bag cleared.');
    }

    public function summary()
    {
        $cart = session()->get('cart', []);
        $subtotal = $this->calculateSubtotal($cart);
        $count = $this->calculateCount($cart);
        $freeShippingThreshold = 150.00;
        $shippingNeeded = max(0, $freeShippingThreshold - $subtotal);
        $shippingProgress = min(100, round(($subtotal / $freeShippingThreshold) * 100));

        return response()->json([
            'items' => array_values($cart),
            'count' => $count,
            'subtotal' => number_format($subtotal, 2),
            'freeShipping' => $subtotal >= $freeShippingThreshold,
            'shippingNeeded' => number_format($shippingNeeded, 2),
            'shippingProgress' => $shippingProgress,
        ]);
    }

    private function calculateSubtotal(array $cart): float
    {
        $sum = 0;
        foreach ($cart as $item) {
            $sum += $item['price'] * $item['quantity'];
        }
        return (float) $sum;
    }

    private function calculateCount(array $cart): int
    {
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }
}

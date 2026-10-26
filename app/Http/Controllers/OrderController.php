<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(string $orderNumber)
    {
        $order = Order::with(['items.product'])->where('order_number', $orderNumber)->firstOrFail();
        return view('orders.show', compact('order'));
    }

    public function track(Request $request)
    {
        $order = null;
        if ($request->filled('order_number')) {
            $order = Order::with('items')
                ->where('order_number', trim($request->order_number))
                ->first();
        }

        return view('orders.track', compact('order'));
    }
}

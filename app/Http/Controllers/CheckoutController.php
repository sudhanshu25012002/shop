<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('info', 'Your shopping bag is empty. Please select an item to purchase.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $coupon = session()->get('coupon');
        $discount = 0;
        if ($coupon) {
            if ($coupon['type'] === 'percent') {
                $discount = ($subtotal * $coupon['value']) / 100;
            } else {
                $discount = $coupon['value'];
            }
        }

        // Complimentary shipping over $150
        $shippingFee = ($subtotal >= 150) ? 0.00 : 25.00;
        $tax = ($subtotal - $discount) * 0.08; // 8% sales tax
        $total = max(0, ($subtotal - $discount) + $shippingFee + $tax);

        $user = auth()->user();

        return view('checkout.index', compact('cart', 'subtotal', 'coupon', 'discount', 'shippingFee', 'tax', 'total', 'user'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        $code = strtoupper(trim($request->code));

        $validCoupons = [
            'WELCOME10' => ['code' => 'WELCOME10', 'type' => 'percent', 'value' => 10, 'label' => '10% Welcome Atelier Discount'],
            'AURELIA20' => ['code' => 'AURELIA20', 'type' => 'percent', 'value' => 20, 'label' => '20% VIP Client Privilege'],
            'FREESHIP'  => ['code' => 'FREESHIP',  'type' => 'fixed',   'value' => 25, 'label' => 'Complimentary White-Glove Shipping'],
        ];

        if (isset($validCoupons[$code])) {
            session()->put('coupon', $validCoupons[$code]);
            return redirect()->back()->with('success', "Privilege code {$code} applied successfully!");
        }

        return redirect()->back()->with('error', 'Invalid promotion code. Try "WELCOME10" or "AURELIA20".');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->back()->with('info', 'Privilege code removed.');
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Your shopping bag is empty.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:50',
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'payment_method' => 'required|in:card,cod,express',
            'notes' => 'nullable|string|max:500',
            // Card simulation fields (optional if card selected)
            'card_number' => 'nullable|string',
            'card_name' => 'nullable|string',
        ]);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $coupon = session()->get('coupon');
        $discount = 0;
        if ($coupon) {
            if ($coupon['type'] === 'percent') {
                $discount = ($subtotal * $coupon['value']) / 100;
            } else {
                $discount = $coupon['value'];
            }
        }

        $shippingFee = ($subtotal >= 150) ? 0.00 : 25.00;
        $tax = round(($subtotal - $discount) * 0.08, 2);
        $total = max(0, round(($subtotal - $discount) + $shippingFee + $tax, 2));

        $orderNumber = 'AUR-' . date('Y') . '-' . strtoupper(Str::random(6));

        $order = DB::transaction(function () use ($validated, $orderNumber, $subtotal, $discount, $shippingFee, $tax, $total, $cart) {
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => auth()->id(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'shipping_country' => $validated['shipping_country'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping_fee' => $shippingFee,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_status' => ($validated['payment_method'] === 'cod') ? 'pending' : 'paid',
                'status' => 'processing',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'product_image' => $item['image'],
                    'size' => $item['size'],
                    'color' => $item['color'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total' => $item['price'] * $item['quantity'],
                ]);

                // Decrement inventory
                Product::where('id', $item['product_id'])->decrement('stock', $item['quantity']);
            }

            return $order;
        });

        // Clear bag & coupon
        session()->forget(['cart', 'coupon']);

        return redirect()->route('orders.show', $order->order_number)->with('success', 'Thank you! Your atelier order has been placed.');
    }
}

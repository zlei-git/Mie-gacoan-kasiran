<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Order;
use App\Models\Promo;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $branches = Branch::where('is_open', true)->get();
        $tables = RestaurantTable::where('status', 'available')->get();
        $promos = Promo::where('is_active', true)->get();

        return view('checkout.index', compact('branches', 'tables', 'promos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_type' => ['required', 'string', 'in:dine_in,pickup_now,delivery'],
            'branch_id' => ['required', 'exists:branches,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'table_number' => ['nullable', 'string'],
            'payment_method' => ['required', 'string', 'in:qris,cash,transfer'],
            'items' => ['required', 'string'], // JSON encoded string from client cart
            'notes' => ['nullable', 'string', 'max:500'],
            'promo_code' => ['nullable', 'string'],
        ]);

        $items = json_decode($validated['items'], true);
        if (empty($items) || !is_array($items)) {
            return back()->withErrors(['items' => 'Keranjang pesanan tidak boleh kosong.'])->withInput();
        }

        $subtotal = 0;
        foreach ($items as $item) {
            $qty = intval($item['quantity'] ?? 1);
            $price = intval($item['price'] ?? 0);
            $subtotal += ($qty * $price);
        }

        $discount = 0;
        if (!empty($validated['promo_code'])) {
            $promo = Promo::where('code', strtoupper($validated['promo_code']))
                ->where('is_active', true)
                ->first();
            if ($promo && $subtotal >= $promo->min_order) {
                if ($promo->discount_type === 'percent') {
                    $discount = (int) round(($subtotal * $promo->discount_value) / 100);
                } else {
                    $discount = min($subtotal, $promo->discount_value);
                }
            }
        }

        $tax = (int) round(($subtotal - $discount) * 0.10); // PB1 10%
        $total = max(0, $subtotal - $discount + $tax);

        $orderCode = 'KM-' . strtoupper(Str::random(3)) . '-' . rand(1000, 9999);

        $order = Order::create([
            'order_code' => $orderCode,
            'user_id' => Auth::id(),
            'branch_id' => $validated['branch_id'],
            'order_type' => $validated['order_type'],
            'table_number' => $validated['table_number'] ?? null,
            'pickup_time_slot' => $validated['order_type'] === 'pickup_now' ? '15 - 20 Menit' : null,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'payment_method' => $validated['payment_method'],
            'payment_status' => $validated['payment_method'] === 'cash' ? 'pending' : 'paid',
            'status' => 'in_kitchen',
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $total,
            'items' => $items,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('orders.track', ['code' => $order->order_code])
            ->with('toast_success', 'Pesanan berhasil dikirim ke dapur! Nomor antrean: ' . $order->order_code);
    }
}

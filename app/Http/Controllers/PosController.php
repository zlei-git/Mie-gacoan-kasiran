<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promo;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::where('is_available', true)->get();
        $tables = RestaurantTable::all();
        $promos = Promo::where('is_active', true)->get();
        $branches = Branch::all();
        $activeBranch = Branch::first();

        $todayOrders = Order::whereDate('created_at', today())
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get();

        return view('pos.index', compact('products', 'tables', 'promos', 'branches', 'activeBranch', 'todayOrders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_type' => ['required', 'string', 'in:dine_in,pickup_now,takeaway'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:20'],
            'table_number' => ['nullable', 'string'],
            'payment_method' => ['required', 'string', 'in:cash,qris,debit'],
            'items' => ['required', 'string'],
            'discount' => ['nullable', 'integer'],
            'notes' => ['nullable', 'string'],
        ]);

        $items = json_decode($validated['items'], true);
        if (empty($items) || !is_array($items)) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Daftar menu pesanan kosong.'], 422);
            }
            return back()->withErrors(['items' => 'Item pesanan kosong.']);
        }

        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += (intval($item['price'] ?? 0) * intval($item['quantity'] ?? 1));
        }

        $discount = intval($validated['discount'] ?? 0);
        $tax = (int) round(($subtotal - $discount) * 0.10);
        $total = max(0, $subtotal - $discount + $tax);

        $orderCode = 'POS-' . date('ymd') . '-' . rand(100, 999);

        $order = Order::create([
            'order_code' => $orderCode,
            'user_id' => Auth::id(),
            'branch_id' => Branch::first()?->id ?? 1,
            'order_type' => $validated['order_type'],
            'table_number' => $validated['table_number'] ?? null,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'] ?? '-',
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'paid',
            'status' => 'in_kitchen',
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $total,
            'items' => $items,
            'notes' => $validated['notes'] ?? null,
        ]);

        // If table assigned, mark table as occupied
        if (!empty($validated['table_number'])) {
            RestaurantTable::where('table_number', $validated['table_number'])
                ->update(['status' => 'occupied']);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Transaksi POS berhasil disimpan!',
                'order' => $order,
            ]);
        }

        return redirect()->route('pos.index')
            ->with('toast_success', 'Transaksi Kasir ' . $orderCode . ' berhasil dicetak & diproses!');
    }

    public function sync(Request $request)
    {
        $ordersData = $request->input('orders', []);
        $synced = [];

        foreach ($ordersData as $data) {
            $orderCode = $data['order_code'] ?? ('OFF-' . date('ymd') . '-' . rand(100, 999));
            
            // Avoid duplicate orders
            if (!Order::where('order_code', $orderCode)->exists()) {
                $order = Order::create([
                    'order_code' => $orderCode,
                    'user_id' => Auth::id(),
                    'branch_id' => Branch::first()?->id ?? 1,
                    'order_type' => $data['order_type'] ?? 'dine_in',
                    'table_number' => $data['table_number'] ?? null,
                    'customer_name' => $data['customer_name'] ?? 'Pelanggan POS Offline',
                    'customer_phone' => $data['customer_phone'] ?? '-',
                    'payment_method' => $data['payment_method'] ?? 'cash',
                    'payment_status' => 'paid',
                    'status' => 'in_kitchen',
                    'subtotal' => intval($data['subtotal'] ?? 0),
                    'discount' => intval($data['discount'] ?? 0),
                    'tax' => intval($data['tax'] ?? 0),
                    'total' => intval($data['total'] ?? 0),
                    'items' => $data['items'] ?? [],
                    'notes' => '[Offline Sync] ' . ($data['notes'] ?? ''),
                ]);
                $synced[] = $orderCode;
            } else {
                $synced[] = $orderCode;
            }
        }

        return response()->json([
            'success' => true,
            'message' => count($synced) . ' pesanan offline berhasil disinkronisasi ke server pusat.',
            'synced' => $synced,
        ]);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $newStatus = $request->validate([
            'status' => ['required', 'string', 'in:in_kitchen,ready_pickup,completed,cancelled']
        ])['status'];

        $order->update(['status' => $newStatus]);

        if ($newStatus === 'completed' && !empty($order->table_number)) {
            RestaurantTable::where('table_number', $order->table_number)
                ->update(['status' => 'available']);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'order' => $order]);
        }

        return back()->with('toast_success', 'Status pesanan ' . $order->order_code . ' diperbarui ke: ' . $newStatus);
    }
}

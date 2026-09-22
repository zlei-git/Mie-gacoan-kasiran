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

    public function liveOrderFeed(Request $request)
    {
        $lastId = intval($request->query('last_id', 0));

        // Active orders that are waiting in kitchen or pending
        $activeOrders = Order::whereIn('status', ['in_kitchen', 'pending'])
            ->orderBy('id', 'desc')
            ->take(20)
            ->get();

        $maxId = Order::max('id') ?? 0;

        // New orders strictly greater than last_id
        $newOrders = [];
        if ($lastId > 0 && $maxId > $lastId) {
            $newOrders = Order::where('id', '>', $lastId)
                ->orderBy('id', 'asc')
                ->get();
        }

        $formatOrder = function ($order) {
            $itemsText = [];
            if (is_array($order->items)) {
                foreach ($order->items as $item) {
                    $qty = $item['quantity'] ?? 1;
                    $name = $item['name'] ?? 'Item';
                    $spicy = isset($item['spicy_level']) && $item['spicy_level'] !== null ? " (Lv.{$item['spicy_level']})" : '';
                    $itemsText[] = "{$qty}x {$name}{$spicy}";
                }
            }

            $typeLabel = match ($order->order_type) {
                'dine_in' => 'Dine In ' . ($order->table_number ? "(Meja {$order->table_number})" : ''),
                'pickup_now' => 'Takeaway / Ambil Sendiri',
                'delivery' => 'Delivery Antar',
                default => ucfirst(str_replace('_', ' ', (string) $order->order_type)),
            };

            return [
                'id' => $order->id,
                'order_code' => $order->order_code,
                'customer_name' => $order->customer_name,
                'customer_phone' => $order->customer_phone,
                'order_type_label' => $typeLabel,
                'table_number' => $order->table_number,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'payment_method' => strtoupper((string) $order->payment_method),
                'total' => $order->total,
                'total_formatted' => 'Rp ' . number_format($order->total, 0, ',', '.'),
                'items_summary' => implode(', ', array_slice($itemsText, 0, 3)) . (count($itemsText) > 3 ? ' +' . (count($itemsText) - 3) . ' lainnya' : ''),
                'items_count' => count($itemsText),
                'created_at_time' => $order->created_at ? $order->created_at->format('H:i') : '',
                'created_at_diff' => $order->created_at ? $order->created_at->diffForHumans() : 'Baru saja',
            ];
        };

        return response()->json([
            'success' => true,
            'latest_id' => $maxId,
            'active_count' => $activeOrders->count(),
            'active_orders' => $activeOrders->map($formatOrder),
            'new_orders' => collect($newOrders)->map($formatOrder),
            'server_time' => now()->format('H:i:s'),
        ]);
    }
}

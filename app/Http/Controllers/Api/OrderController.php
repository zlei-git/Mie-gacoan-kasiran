<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('branch')->latest();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $orders = $query->get();

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'nullable|exists:branches,id',
            'order_type' => 'required|in:pickup_now,pickup_scheduled,dine_in',
            'table_number' => 'nullable|string',
            'pickup_time_slot' => 'nullable|string',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:50',
            'payment_method' => 'required|string',
            'subtotal' => 'required|integer',
            'discount' => 'nullable|integer',
            'tax' => 'nullable|integer',
            'total' => 'required|integer',
            'items' => 'required|array',
            'notes' => 'nullable|string',
        ]);

        $prefix = $validated['order_type'] === 'dine_in' ? 'KM-DIN-' : 'KM-PKP-';
        $orderCode = $prefix . strtoupper(Str::random(4)) . rand(10, 99);

        // Calculate default pickup estimate if not provided
        $pickupSlot = $validated['pickup_time_slot'] ?? ($validated['order_type'] === 'pickup_now' ? '10 - 15 Menit' : 'Sesuai Jadwal');

        $order = Order::create([
            'order_code' => $orderCode,
            'branch_id' => $validated['branch_id'] ?? Branch::first()?->id,
            'order_type' => $validated['order_type'],
            'table_number' => $validated['table_number'] ?? null,
            'pickup_time_slot' => $pickupSlot,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'paid',
            'status' => 'in_kitchen',
            'subtotal' => $validated['subtotal'],
            'discount' => $validated['discount'] ?? 0,
            'tax' => $validated['tax'] ?? 0,
            'total' => $validated['total'],
            'items' => $validated['items'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat!',
            'data' => $order->load('branch'),
        ], 201);
    }

    public function show($code)
    {
        $order = Order::with('branch')
            ->where('order_code', $code)
            ->orWhere('id', $code)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    public function updateStatus(Request $request, $code)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending_payment,in_kitchen,ready_pickup,completed,cancelled',
        ]);

        $order = Order::where('order_code', $code)
            ->orWhere('id', $code)
            ->firstOrFail();

        $order->update([
            'status' => $validated['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status pesanan berhasil diperbarui',
            'data' => $order,
        ]);
    }
}

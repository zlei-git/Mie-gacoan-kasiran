<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promo;
use App\Models\RestaurantTable;
use App\Models\TableBooking;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $todayRevenue = Order::where('payment_status', 'paid')->whereDate('created_at', today())->sum('total');
        $todayOrdersCount = Order::whereDate('created_at', today())->count();
        $inKitchenOrdersCount = Order::where('status', 'in_kitchen')->count();
        $totalProductsCount = Product::count();
        
        $totalTables = RestaurantTable::count();
        $occupiedTables = RestaurantTable::where('status', 'occupied')->count();
        $tableOccupancy = $totalTables > 0 ? round(($occupiedTables / $totalTables) * 100) : 0;

        $recentOrders = Order::orderBy('created_at', 'desc')->take(8)->get();
        $recentBookings = TableBooking::orderBy('booking_date', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'todayRevenue',
            'todayOrdersCount',
            'inKitchenOrdersCount',
            'totalProductsCount',
            'tableOccupancy',
            'occupiedTables',
            'totalTables',
            'recentOrders',
            'recentBookings'
        ));
    }

    public function products()
    {
        $products = Product::orderBy('category')->orderBy('name')->get();
        return view('admin.products', compact('products'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'unique:products,code'],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:mie,dimsum,minuman,paket'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['required', 'string'],
            'image' => ['required', 'url'],
            'has_spicy_level' => ['nullable', 'boolean'],
            'max_spicy_level' => ['nullable', 'integer', 'min:0', 'max:10'],
        ]);

        Product::create([
            'code' => strtoupper($validated['code']),
            'name' => $validated['name'],
            'category' => $validated['category'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'image' => $validated['image'],
            'has_spicy_level' => $request->boolean('has_spicy_level'),
            'max_spicy_level' => $validated['max_spicy_level'] ?? ($request->boolean('has_spicy_level') ? 8 : 0),
            'is_available' => true,
        ]);

        return redirect()->route('admin.products')->with('toast_success', 'Menu baru berhasil ditambahkan.');
    }

    public function toggleProductStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_available' => !$product->is_available]);

        return back()->with('toast_success', 'Status ketersediaan ' . $product->name . ' diperbarui.');
    }

    public function orders(Request $request)
    {
        $status = $request->query('status');
        $query = Order::with('branch')->orderBy('created_at', 'desc');

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(15);
        return view('admin.orders', compact('orders', 'status'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending_payment,in_kitchen,ready_pickup,completed,cancelled']
        ]);

        $order->update(['status' => $validated['status']]);

        if ($validated['status'] === 'completed' && !empty($order->table_number)) {
            RestaurantTable::where('table_number', $order->table_number)->update(['status' => 'available']);
        }

        return back()->with('toast_success', 'Status pesanan ' . $order->order_code . ' berhasil diubah.');
    }

    public function tables()
    {
        $tables = RestaurantTable::orderBy('room')->orderBy('table_number')->get();
        return view('admin.tables', compact('tables'));
    }

    public function updateTableStatus(Request $request, $id)
    {
        $table = RestaurantTable::findOrFail($id);
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:available,occupied,reserved']
        ]);

        $table->update(['status' => $validated['status']]);

        return back()->with('toast_success', 'Status Meja ' . $table->table_number . ' diubah ke ' . $validated['status']);
    }

    public function bookings()
    {
        $bookings = TableBooking::with('table')->orderBy('booking_date', 'desc')->paginate(15);
        return view('admin.bookings', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $booking = TableBooking::findOrFail($id);
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,confirmed,seated,cancelled']
        ]);

        $booking->update(['status' => $validated['status']]);

        return back()->with('toast_success', 'Status booking ' . $booking->booking_code . ' diperbarui.');
    }

    public function promos()
    {
        $promos = Promo::all();
        return view('admin.promos', compact('promos'));
    }

    public function storePromo(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'unique:promos,code'],
            'title' => ['required', 'string'],
            'discount_type' => ['required', 'string', 'in:percent,fixed'],
            'discount_value' => ['required', 'integer', 'min:1'],
            'min_order' => ['required', 'integer', 'min:0'],
        ]);

        Promo::create([
            'code' => strtoupper($validated['code']),
            'title' => $validated['title'],
            'discount_type' => $validated['discount_type'],
            'discount_value' => $validated['discount_value'],
            'min_order' => $validated['min_order'],
            'is_active' => true,
        ]);

        return redirect()->route('admin.promos')->with('toast_success', 'Kode promo berhasil dibuat.');
    }
}

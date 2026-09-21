<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function track($code)
    {
        $order = Order::with('branch')->where('order_code', $code)->firstOrFail();
        return view('orders.track', compact('order'));
    }

    public function history()
    {
        $orders = Order::with('branch')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.history', compact('orders'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\RestaurantTable;
use App\Models\TableBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $branches = Branch::where('is_open', true)->get();
        $tables = RestaurantTable::all();
        $userBookings = Auth::check() 
            ? TableBooking::where('user_id', Auth::id())->orderBy('booking_date', 'desc')->get() 
            : collect();

        return view('booking.index', compact('branches', 'tables', 'userBookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => ['required', 'exists:branches,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'string'],
            'guests_count' => ['required', 'integer', 'min:1', 'max:20'],
            'room_preference' => ['required', 'string', 'in:Indoor AC,Outdoor,VIP Room'],
            'table_id' => ['nullable', 'exists:restaurant_tables,id'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $bookingCode = 'TBK-' . date('ymd') . '-' . strtoupper(Str::random(4));

        $booking = TableBooking::create([
            'booking_code' => $bookingCode,
            'user_id' => Auth::id(),
            'branch_id' => $validated['branch_id'],
            'table_id' => $validated['table_id'] ?? null,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'guests_count' => $validated['guests_count'],
            'room_preference' => $validated['room_preference'],
            'status' => 'confirmed',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('booking.index')
            ->with('toast_success', 'Reservasi meja Anda berhasil dikonfirmasi! Kode Booking: ' . $booking->booking_code);
    }
}

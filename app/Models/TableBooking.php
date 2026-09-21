<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'branch_id',
        'table_id',
        'customer_name',
        'customer_phone',
        'booking_date',
        'booking_time',
        'guests_count',
        'room_preference',
        'status',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function table()
    {
        return $this->belongsTo(RestaurantTable::class, 'table_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'branch_id',
        'order_type',
        'table_number',
        'pickup_time_slot',
        'customer_name',
        'customer_phone',
        'payment_method',
        'payment_status',
        'status',
        'subtotal',
        'discount',
        'tax',
        'total',
        'items',
        'notes',
    ];

    protected $casts = [
        'items' => 'array',
        'subtotal' => 'integer',
        'discount' => 'integer',
        'tax' => 'integer',
        'total' => 'integer',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'discount_type',
        'discount_value',
        'min_order',
        'is_active',
    ];

    protected $casts = [
        'discount_value' => 'integer',
        'min_order' => 'integer',
        'is_active' => 'boolean',
    ];
}

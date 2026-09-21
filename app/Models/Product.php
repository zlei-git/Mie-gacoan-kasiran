<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'category',
        'price',
        'description',
        'image',
        'has_spicy_level',
        'max_spicy_level',
        'is_available',
        'is_popular',
        'rating',
        'rating_count',
    ];

    protected $casts = [
        'price' => 'integer',
        'has_spicy_level' => 'boolean',
        'max_spicy_level' => 'integer',
        'is_available' => 'boolean',
        'is_popular' => 'boolean',
        'rating' => 'float',
        'rating_count' => 'integer',
    ];
}

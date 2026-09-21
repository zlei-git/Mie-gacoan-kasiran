<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'address',
        'city',
        'phone',
        'opening_hours',
        'is_open',
    ];

    protected $casts = [
        'is_open' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

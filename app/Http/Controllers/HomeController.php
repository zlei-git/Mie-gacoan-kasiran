<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Models\Promo;

class HomeController extends Controller
{
    public function index()
    {
        $popularProducts = Product::where('is_available', true)
            ->where('is_popular', true)
            ->take(6)
            ->get();

        $branches = Branch::where('is_open', true)->get();
        $promos = Promo::where('is_active', true)->get();

        return view('home', compact('popularProducts', 'branches', 'promos'));
    }
}

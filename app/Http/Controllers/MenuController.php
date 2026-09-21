<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Promo;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category', 'all');
        $search = $request->query('q');

        $query = Product::where('is_available', true);

        if ($category !== 'all' && !empty($category)) {
            $query->where('category', $category);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('is_popular', 'desc')->get();
        $promos = Promo::where('is_active', true)->get();

        $categories = [
            ['id' => 'all', 'name' => 'Semua Menu', 'icon' => 'grid'],
            ['id' => 'mie', 'name' => 'Mie Pedas', 'icon' => 'flame'],
            ['id' => 'dimsum', 'name' => 'Dimsum Renyah', 'icon' => 'utensils'],
            ['id' => 'minuman', 'name' => 'Minuman Segar', 'icon' => 'cup'],
        ];

        return view('menu.index', compact('products', 'category', 'search', 'promos', 'categories'));
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::all();
        return response()->json([
            'success' => true,
            'data' => $branches,
        ]);
    }

    public function show($id)
    {
        $branch = Branch::with('orders')->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $branch,
        ]);
    }
}

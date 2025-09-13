<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Sale;
use App\Models\StockLog; // <- assuming you log stock movements
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $productsCount = Product::count();
        $suppliersCount = Supplier::count();
        $salesCount = Sale::count();

        // 👇 fetch top 5 fast moving items (most OUT)
        $fastMovingItems = StockLog::select('product_id', DB::raw('SUM(quantity) as total_out'))
            ->where('type', 'out') // assuming you store IN/OUT in StockLog
            ->groupBy('product_id')
            ->orderByDesc('total_out')
            ->with('product')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'productsCount',
            'suppliersCount',
            'salesCount',
            'fastMovingItems'
        ));
    }
}

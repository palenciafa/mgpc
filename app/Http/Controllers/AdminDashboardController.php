<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Sale;
use App\Models\StockLog;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $productsCount = Product::count();
        $suppliersCount = Supplier::count();
        $salesCount = Sale::count();
        $stockLogs = StockLog::all();

        // Get top 5 fast moving products with total quantity sold and total sales
        $fastMovingItems = Product::withSum('sales', 'total_price') // total sales per product
            ->withCount(['sales as total_out' => function ($query) {
                $query->select(DB::raw("SUM(quantity)")); // sum of quantity sold
            }])
            ->orderByDesc('total_out')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'productsCount',
            'suppliersCount',
            'salesCount',
            'fastMovingItems',
            'stockLogs',
        ));
    }
}

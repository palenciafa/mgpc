<?php

namespace App\Http\Controllers;

use App\Models\StockLog;

class StockLogController extends Controller
{
    public function index()
    {
        // Get all stock logs with product relationship
        $stockLogs = StockLog::with('product')->latest()->get();

        // Calculate fast-moving items (based on OUT transactions)
        $fastMovingItems = StockLog::select('product_id')
            ->where('type', 'out')
            ->selectRaw('SUM(quantity) as total_out')
            ->groupBy('product_id')
            ->orderByDesc('total_out')
            ->with('product')
            ->take(5) // top 5 fast moving items
            ->get();

        return view('stock_logs.index', compact('stockLogs', 'fastMovingItems'));
    }
}

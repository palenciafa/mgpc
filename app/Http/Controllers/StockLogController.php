<?php



namespace App\Http\Controllers;

use App\Models\StockLog;

class StockLogController extends Controller
{
    public function index()
    {
        $stockLogs = StockLog::with('product')->latest()->get();
        return view('stock_logs.index', compact('stockLogs'));
    }
}

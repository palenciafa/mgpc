<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Sale;
use App\Models\StockLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $productsCount = Product::count();
        $suppliersCount = Supplier::count();
        $salesCount = Sale::count();
        $stockLogs = StockLog::all();

        // Get top 5 fast moving products with total quantity sold and total sales
        $fastMovingItems = Product::withSum('sales', 'total_price')
            ->withCount([
                'sales as total_out' => function ($query) {
                    $query->select(DB::raw("SUM(quantity)"));
                }
            ])
            ->orderByDesc('total_out')
            ->take(5)
            ->get();

        // 📊 Daily profit for last 7 days
        $dailyProfit = DB::table('stock_logs')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(CASE WHEN type="out" THEN total_price ELSE 0 END) - SUM(CASE WHEN type="in" THEN buying_price ELSE 0 END) as profit')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 📊 Monthly profit for last 12 months
        $monthlyProfit = DB::table('stock_logs')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(CASE WHEN type="out" THEN total_price ELSE 0 END) - SUM(CASE WHEN type="in" THEN buying_price ELSE 0 END) as profit')
            )
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // 📊 Yearly profit
        $yearlyProfit = DB::table('stock_logs')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(CASE WHEN type="out" THEN total_price ELSE 0 END) - SUM(CASE WHEN type="in" THEN buying_price ELSE 0 END) as profit')
            )
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        // 📅 Custom date range profit (if start_date and end_date provided)
        $customProfit = null;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        if ($startDate && $endDate) {
            $customProfit = DB::table('stock_logs')
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('SUM(CASE WHEN type="out" THEN total_price ELSE 0 END) - SUM(CASE WHEN type="in" THEN buying_price ELSE 0 END) as profit')
                )
                ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        }

        return view('admin.dashboard', compact(
            'productsCount',
            'suppliersCount',
            'salesCount',
            'fastMovingItems',
            'stockLogs',
            'dailyProfit',
            'monthlyProfit',
            'yearlyProfit',
            'customProfit'
        ));
    }
    public function getProfit(Request $request)
{
    $start = $request->query('start');
    $end = $request->query('end');

    // Validate dates
    if (!$start || !$end) {
        return response()->json([
            'labels' => [],
            'values' => []
        ]);
    }

    // Query stock_logs instead of sales
    $profits = DB::table('stock_logs')
        ->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(CASE WHEN type="out" THEN total_price ELSE 0 END) - SUM(CASE WHEN type="in" THEN buying_price ELSE 0 END) as profit')
        )
        ->whereDate('created_at', '>=', $start)
        ->whereDate('created_at', '<=', $end)
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    return response()->json([
        'labels' => $profits->pluck('date'),
        'values' => $profits->pluck('profit'),
    ]);
}



}

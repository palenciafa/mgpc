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
        // 📦 Counts
        $productsCount  = Product::count();
        $suppliersCount = Supplier::count();
        $salesCount     = Sale::count();
        $stockLogs      = StockLog::latest()->take(10)->get();

        // 🚀 Fast moving products (top 5)
        $fastMovingItems = Product::withSum('sales', 'total_price')
            ->withCount([
                'sales as total_out' => function ($query) {
                    $query->select(DB::raw('SUM(quantity)'));
                }
            ])
            ->orderByDesc('total_out')
            ->take(5)
            ->get();

        // 📅 Date helpers (IMPORTANT: separate Carbon instances)
        $today        = Carbon::today();
        $sevenDaysAgo = Carbon::today()->subDays(6);
        $oneYearAgo   = Carbon::today()->subYear();

        // 📊 DAILY PROFIT — last 7 days only
        $dailyProfit = DB::table('stock_logs')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('
                    SUM(CASE WHEN type = "out" THEN total_price ELSE 0 END)
                    -
                    SUM(CASE WHEN type = "in" THEN buying_price ELSE 0 END)
                    AS profit
                ')
            )
            ->whereDate('created_at', '>=', $sevenDaysAgo)
            ->whereDate('created_at', '<=', $today)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 📊 MONTHLY PROFIT — last 12 months
        $monthlyProfit = DB::table('stock_logs')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('
                    SUM(CASE WHEN type = "out" THEN total_price ELSE 0 END)
                    -
                    SUM(CASE WHEN type = "in" THEN buying_price ELSE 0 END)
                    AS profit
                ')
            )
            ->whereDate('created_at', '>=', $oneYearAgo)
            ->whereDate('created_at', '<=', $today)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Ensure we have a value for each of the last 12 months (fill zeros)
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $months->push(Carbon::today()->subMonths($i)->format('Y-m'));
        }

        $monthlyMap = $monthlyProfit->pluck('profit', 'month');
        $monthlyProfitFull = $months->map(function ($m) use ($monthlyMap) {
            return (object)[
                'month' => $m,
                'profit' => isset($monthlyMap[$m]) ? (float) $monthlyMap[$m] : 0
            ];
        });

        // 📊 YEARLY PROFIT — last 5 years (fill zeros where missing)
        $yearlyProfit = DB::table('stock_logs')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(CASE WHEN type = "out" THEN total_price ELSE 0 END) - SUM(CASE WHEN type = "in" THEN buying_price ELSE 0 END) AS profit')
            )
            ->whereDate('created_at', '<=', $today)
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        $currentYear = (int) Carbon::now()->format('Y');
        $years = collect();
        for ($y = $currentYear - 4; $y <= $currentYear; $y++) {
            $years->push((string) $y);
        }

        $yearlyMap = $yearlyProfit->pluck('profit', 'year');
        $yearlyProfitFull = $years->map(function ($y) use ($yearlyMap) {
            return (object)[
                'year' => $y,
                'profit' => isset($yearlyMap[$y]) ? (float) $yearlyMap[$y] : 0
            ];
        });

        return view('admin.dashboard', compact(
            'productsCount',
            'suppliersCount',
            'salesCount',
            'fastMovingItems',
            'stockLogs',
            'dailyProfit',
            'monthlyProfitFull',
            'yearlyProfitFull'
        ));

    }

    /**
     * 📅 Custom date range profit (API)
     */
    public function getProfit(Request $request)
    {
        $group = $request->query('group', 'daily');
        $start = $request->query('start');
        $end   = $request->query('end');

        // Defaults when no range is provided
        if (!$start || !$end) {
            $today = Carbon::today();
            if ($group === 'monthly') {
                $start = Carbon::today()->subMonths(11)->startOfMonth()->toDateString();
                $end = $today->endOfMonth()->toDateString();
            } elseif ($group === 'yearly') {
                $start = '1970-01-01';
                $end = $today->toDateString();
            } else {
                // daily -> last 7 days
                $start = Carbon::today()->subDays(6)->toDateString();
                $end = $today->toDateString();
            }
        }

        if ($group === 'monthly') {
            $profits = DB::table('stock_logs')
                ->select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as label'),
                    DB::raw('SUM(CASE WHEN type = "out" THEN total_price ELSE 0 END) - SUM(CASE WHEN type = "in" THEN buying_price ELSE 0 END) AS profit')
                )
                ->whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', $end)
                ->groupBy('label')
                ->orderBy('label')
                ->get();
        } elseif ($group === 'yearly') {
            $profits = DB::table('stock_logs')
                ->select(
                    DB::raw('YEAR(created_at) as label'),
                    DB::raw('SUM(CASE WHEN type = "out" THEN total_price ELSE 0 END) - SUM(CASE WHEN type = "in" THEN buying_price ELSE 0 END) AS profit')
                )
                ->whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', $end)
                ->groupBy('label')
                ->orderBy('label')
                ->get();
        } else {
            // daily
            $profits = DB::table('stock_logs')
                ->select(
                    DB::raw('DATE(created_at) as label'),
                    DB::raw('SUM(CASE WHEN type = "out" THEN total_price ELSE 0 END) - SUM(CASE WHEN type = "in" THEN buying_price ELSE 0 END) AS profit')
                )
                ->whereDate('created_at', '>=', $start)
                ->whereDate('created_at', '<=', $end)
                ->groupBy('label')
                ->orderBy('label')
                ->get();
        }

        return response()->json([
            'labels' => $profits->pluck('label'),
            'values' => $profits->pluck('profit'),
        ]);
    }
}

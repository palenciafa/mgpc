<?php

namespace App\Http\Controllers;

use App\Models\StockLog;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StockLogsExport;

class StockLogController extends Controller
{
    public function index(Request $request)
    {
        $query = StockLog::with(['product', 'user', 'supplier', 'sale']);

        // Filter by type IN/OUT
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Optional: filter by supplier
        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        $stockLogs = $query->orderBy('created_at', 'desc')->paginate(10);
        $suppliers = Supplier::all();

        return view('stock_logs.index', compact('stockLogs', 'suppliers'));
    }

    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();

        return view('stock_logs.create', compact('products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'   => 'required|exists:products,id',
            'quantity'     => 'required|integer|min:1',
            'supplier_id'  => 'nullable|exists:suppliers,id',
            'buying_price' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Add stock
        $product->increment('stock', $request->quantity);

        // Only IN logs here
        StockLog::create([
            'product_id'   => $product->id,
            'type'         => 'in',
            'quantity'     => $request->quantity,
            'user_id'      => auth()->id(),
            'supplier_id'  => $request->supplier_id,
            'buying_price' => $request->buying_price,
        ]);

        return redirect()->route('stock_logs.index')->with('success', 'Stock added successfully.');
    }

    public function destroy(StockLog $stockLog)
    {
        // Only allow deleting IN logs
        if ($stockLog->type === 'in') {
            $product = $stockLog->product;
            $product->decrement('stock', $stockLog->quantity);
            $stockLog->delete();
        }

        return redirect()->route('stock_logs.index')->with('success', 'Stock log deleted successfully.');
    }

    public function export(Request $request)
    {
        $query = StockLog::with(['product', 'user', 'supplier', 'sale']);

        // Apply the same filters as the index
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        $filteredLogs = $query->orderBy('created_at', 'desc')->get();

        // Pass the filtered collection to the export
        return Excel::download(new StockLogsExport($filteredLogs), 'stock_logs.xlsx');
    }
}

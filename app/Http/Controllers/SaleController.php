<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with('product.category');

        // Search by customer name or product name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhereHas('product', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('product.category', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        $sales = $query->latest()->paginate(10)->withQueryString();
        $products = Product::all();
        $categories = Category::all();

        return view('sales.index', compact('sales', 'products', 'categories'));
    }

    public function create()
    {
        $products = Product::all();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
{
    $request->validate([
        'product_id'    => 'required|exists:products,id',
        'quantity'      => 'required|integer|min:1',
        'customer_name' => 'required|string|max:255',
    ]);

    DB::transaction(function () use ($request) {
        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            abort(400, 'Not enough stock available.');
        }

        $totalPrice = $product->price * $request->quantity;

        // ✅ Create Sale (NO user_id)
        $sale = Sale::create([
            'product_id'    => $product->id,
            'quantity'      => $request->quantity,
            'total_price'   => $totalPrice,
            'customer_name' => $request->customer_name,
        ]);

        // Deduct stock
        $product->decrement('stock', $request->quantity);

        // ⚠️ StockLog: ONLY keep user_id if the column EXISTS there
        StockLog::create([
            'product_id'  => $product->id,
            'type'        => 'out',
            'quantity'    => $request->quantity,
            'total_price' => $totalPrice,
            'sale_id'     => $sale->id,
        ]);
    });

    return redirect()->route('sales.index')->with('success', 'Sale recorded successfully.');
}

    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        DB::transaction(function () use ($sale) {
            // Restore stock
            $product = $sale->product;
            $product->increment('stock', $sale->quantity);

            // Delete associated OUT stock log
            StockLog::where('sale_id', $sale->id)->where('type', 'out')->delete();

            // Delete sale
            $sale->delete();
        });

        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

            // Create Sale
            $sale = Sale::create([
                'product_id'    => $product->id,
                'quantity'      => $request->quantity,
                'total_price'   => $totalPrice,
                'customer_name' => $request->customer_name,
                'user_id'       => Auth::id(),
            ]);

            // Deduct stock
            $product->decrement('stock', $request->quantity);

            // Create OUT StockLog
            StockLog::create([
                'product_id'  => $product->id,
                'type'        => 'out',
                'quantity'    => $request->quantity,
                'total_price' => $totalPrice,
                'sale_id'     => $sale->id,
                'user_id'     => Auth::id(),
            ]);
        });

        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully.');
    }

    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $products = Product::all();
        return view('sales.edit', compact('sale', 'products'));
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'product_id'    => 'required|exists:products,id',
            'quantity'      => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request, $sale) {
            $product = Product::findOrFail($request->product_id);
            $oldQuantity = $sale->quantity;
            $newQuantity = $request->quantity;
            $quantityDifference = $newQuantity - $oldQuantity;

            // Check if new quantity is less than old and if product has enough stock to accommodate the change
            if ($quantityDifference > 0 && $product->stock < $quantityDifference) {
                abort(400, 'Not enough stock available.');
            }

            $totalPrice = $product->price * $newQuantity;

            // Update Sale
            $sale->update([
                'product_id'    => $product->id,
                'quantity'      => $newQuantity,
                'total_price'   => $totalPrice,
                'customer_name' => $request->customer_name,
            ]);

            // Adjust stock based on quantity difference
            if ($quantityDifference > 0) {
                // More quantity needed, deduct from stock
                $product->decrement('stock', $quantityDifference);
            } elseif ($quantityDifference < 0) {
                // Less quantity needed, add back to stock
                $product->increment('stock', abs($quantityDifference));
            }

            // Update the associated OUT StockLog
            StockLog::where('sale_id', $sale->id)
                ->where('type', 'out')
                ->update([
                    'product_id'  => $product->id,
                    'quantity'    => $newQuantity,
                    'total_price' => $totalPrice,
                ]);
        });

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
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
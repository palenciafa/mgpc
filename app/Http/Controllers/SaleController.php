<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('product')->get();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::all();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'sale_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::findOrFail($request->product_id);

            if ($product->stock < $request->quantity) {
                abort(400, 'Not enough stock available.');
            }

            // Deduct stock
            $product->stock -= $request->quantity;
            $product->save();

            // Create Sale record
            $sale = Sale::create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'sale_price' => $request->sale_price,
            ]);

            // Create Stock Log entry
            StockLog::create([
                'product_id' => $product->id,
                'change' => -$request->quantity,
                'note' => 'Sale ID ' . $sale->id,
            ]);
        });

        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully.');
    }

    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }

    // Optional: If you want to allow edits or deletes, you can add them here
}

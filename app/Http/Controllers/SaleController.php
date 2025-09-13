<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Sale;
use App\Models\Product;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('product.category')->paginate(10);
 // or get() if you don’t want pagination

        // Fetch all categories for the filter dropdown
        $categories = Category::all();

        return view('sales.index', compact('sales', 'categories'));
    }

    public function create()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('sales.create', compact('products','categories'));

        // Fetch all categories for the dropdown


    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::findOrFail($request->product_id);

            if ($product->stock < $request->quantity) {
                abort(400, 'Not enough stock available.');
            }

            // Compute total price = product price × quantity
            $totalPrice = $product->price * $request->quantity;

            // Deduct stock
            $product->stock -= $request->quantity;
            $product->save();

            // Create Sale record
            $sale = Sale::create([
                'product_id'  => $request->product_id,
                'quantity'    => $request->quantity,
                'total_price' => $totalPrice,
                'user_id'     => auth()->id(),
                'customer_name' => $request->customer_name,
            ]);

            // Create Stock Log
            StockLog::create([
                'product_id' => $product->id,
                'type'       => 'out', // since it's a sale
                'quantity'   => $request->quantity,
                'reason'     => 'Sale ID ' . $sale->id,
                'user_id'    => auth()->id(), // optional, if you want to track the user,
            ]);
        });

        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully.');
    }

    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'supplier']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->paginate(10)->withQueryString();

        $categories = Category::all();
        $suppliers = Supplier::all();

        $lowStockProducts = Product::where('stock', '<', 100)->get();
        $lowStockCount = $lowStockProducts->count();

        return view('products.index', compact('products', 'categories', 'suppliers', 'lowStockProducts', 'lowStockCount'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.create', compact('categories', 'suppliers'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'buying_price' => 'required|numeric|min:0', // added validation
        ]);

        $product = Product::create($validated);

        // Create initial stock log if stock > 0
        if ($product->stock > 0) {
            StockLog::create([
                'product_id'   => $product->id,
                'type'         => 'in',
                'quantity'     => $product->stock,
                'user_id'      => Auth::id(),
                'supplier_id'  => $product->supplier_id,
                'buying_price' => $request->buying_price, // use form input
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product created.');
    }

    /**
     * Show the form for editing a product.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'price' => 'required|numeric|min:0',
            // you can optionally allow updating buying_price here if needed
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated.');
    }

    /**
     * Delete a product.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }

    /**
     * Add stock via modal.
     */
    public function addStock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'supplier_id' => 'required|exists:suppliers,id',
            'buying_price' => 'required|numeric|min:0',
        ]);

        $product->increment('stock', $request->quantity);

        StockLog::create([
            'product_id'   => $product->id,
            'type'         => 'in',
            'quantity'     => $request->quantity,
            'supplier_id'  => $request->supplier_id,
            'buying_price' => $request->buying_price,
            'user_id'      => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Stock updated successfully!');
    }
}

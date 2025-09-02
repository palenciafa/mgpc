<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Sale;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $productsCount = Product::count();
        $suppliersCount = Supplier::count();
        $salesCount = Sale::count();

        return view('admin.dashboard', compact('productsCount', 'suppliersCount', 'salesCount'));
    }
}

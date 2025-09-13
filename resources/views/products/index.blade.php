@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
        }
    </style>

    <div class="min-h-screen bg-slate-900/90 px-6 py-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Products</h1>
                    <p class="text-slate-400">Manage your products</p>
                </div>
                <a href="{{ route('products.create') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg flex items-center space-x-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span>New Product</span>
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-500/20 border border-green-500/50 text-green-300 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Filters / Search -->
            <form method="GET" action="{{ route('products.index') }}"
                class="flex flex-col md:flex-row items-center justify-between mb-6 space-y-3 md:space-y-0">
                <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}"
                    class="w-full md:w-1/3 px-4 py-2 rounded-lg bg-slate-800/50 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                <div class="flex space-x-2">
                    <select name="category"
                        class="px-4 py-2 rounded-lg bg-slate-800/50 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        Filter
                    </button>
                </div>
            </form>

            <!-- Products Table -->
            <div class="bg-slate-800/50 backdrop-blur-xl rounded-xl border border-slate-700/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-700/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Name</th>
                                <th class="px-6 py-4 text-sm font-semibold text-white text-center align-middle">Stock</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Actions</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Selling Price</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($products as $product)
                                <tr class="hover:bg-slate-700/30 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center mr-3">
                                                <span
                                                    class="text-white font-semibold text-sm">{{ strtoupper(substr($product->name, 0, 2)) }}</span>
                                            </div>
                                            <div>
                                                <div class="text-white font-medium">{{ $product->name }}</div>
                                                <div class="text-slate-400 text-sm">Category: {{ $product->category->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center align-middle">
                                        @php
                                            if ($product->stock >= 100) {
                                                $color = 'border-green-500 text-green-400';
                                            } elseif ($product->stock >= 50) {
                                                $color = 'border-yellow-500 text-yellow-400';
                                            } else {
                                                $color = 'border-red-500 text-red-400';
                                            }
                                        @endphp
                                        <div class="flex justify-center items-center">
                                            <span class="font-medium px-3 py-1 rounded-lg border {{ $color }}">
                                                {{ $product->stock }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <form action="{{ route('products.addStock', $product) }}" method="POST"
                                                class="inline-flex items-center space-x-1">
                                                @csrf
                                                <input type="number" name="quantity" min="1" value="1"
                                                    class="w-16 px-2 py-1 text-sm border rounded-lg focus:ring focus:border-blue-400" />
                                                <button type="submit"
                                                    class="bg-green-500/20 hover:bg-green-500/30 text-green-400 px-3 py-2 rounded-lg text-sm flex items-center space-x-1 transition-colors duration-200">
                                                    Add
                                                </button>
                                            </form>
                                            <a href="{{ route('products.edit', $product) }}"
                                                class="bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-400 px-3 py-2 rounded-lg text-sm flex items-center space-x-1 transition-colors duration-200">
                                                Edit
                                            </a>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST"
                                                class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this product?')"
                                                    class="bg-red-500/20 hover:bg-red-500/30 text-red-400 px-3 py-2 rounded-lg text-sm flex items-center space-x-1 transition-colors duration-200">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-white font-medium">
                                        ₱{{ number_format($product->price, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                        No products found. <a href="{{ route('products.create') }}"
                                            class="text-blue-400 hover:underline">Create your first product</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Pagination -->
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
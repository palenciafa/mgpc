@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
        }
    </style>

    <div class="min-h-screen px-6 py-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-3xl font-bold text-white mb-1">Sales</h1>
                    <p class="text-slate-400">Manage your sales records efficiently</p>
                </div>
                <a href="{{ route('sales.create') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg flex items-center space-x-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span>New Sale</span>
                </a>
            </div>

            <!-- Filters / Search -->
            <form method="GET" action="{{ route('sales.index') }}"
                class="flex flex-col md:flex-row items-center justify-between mb-6 space-y-3 md:space-y-0">
                <div class="w-full md:w-1/3 relative">
                    <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}"
                        class="w-full px-4 py-2 pl-10 rounded-lg bg-slate-800/50 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                    <svg class="w-5 h-5 absolute left-3 top-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
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

            <!-- Sales Table -->
            <div class="bg-slate-800/50 backdrop-blur-xl rounded-xl border border-slate-700/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-700/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Customer</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Product</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Category</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Quantity</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white"></th>Amount</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Date</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($sales as $sale)
                                <tr class="hover:bg-slate-700/30 transition-colors duration-200">

                                <td class="px-6 py-4 text-white font-medium">{{ $sale->customer_name }}</td>

                                    <!-- Product -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-white font-medium">{{ $sale->product->name }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Category -->
                                    <td class="px-6 py-4 text-slate-400">
                                        {{ $sale->product->category->name ?? 'Uncategorized' }}
                                    </td>

                                    <!-- Quantity -->
                                    <td class="px-6 py-4 text-white font-medium">{{ $sale->quantity }}</td>

                                    <!-- Amount -->
                                    <td class="px-6 py-4 text-white font-medium">₱{{ number_format($sale->total_price, 2) }}
                                    </td>

                                    <!-- Date -->
                                    <td class="px-6 py-4 text-slate-400">{{ $sale->created_at->format('M d, Y') }}</td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('sales.edit', $sale) }}"
                                                class="bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-400 px-3 py-2 rounded-lg text-sm flex items-center space-x-1 transition-colors duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                <span>Edit</span>
                                            </a>
                                            <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this sale?')"
                                                    class="bg-red-500/20 hover:bg-red-500/30 text-red-400 px-3 py-2 rounded-lg text-sm flex items-center space-x-1 transition-colors duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    <span>Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                        No sales found. <a href="{{ route('sales.create') }}"
                                            class="text-blue-400 hover:underline">Create your first sale</a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $sales->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
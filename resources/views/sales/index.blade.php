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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>New Sale</span>
            </a>
        </div>

        <!-- Filters / Search -->
        <div class="flex flex-col md:flex-row items-center justify-between mb-6 space-y-3 md:space-y-0">
            <input type="text" placeholder="Search sales..." 
                   class="w-full md:w-1/3 px-4 py-2 rounded-lg bg-slate-800/50 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
            <div class="flex space-x-2">
                <select class="px-4 py-2 rounded-lg bg-slate-800/50 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    Filter
                </button>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500/50 text-green-300 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Category</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Amount</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Date</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @forelse($sales as $sale)
                            <tr class="hover:bg-slate-700/30 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center mr-3">
                                            <span class="text-white font-semibold text-sm">{{ strtoupper(substr($sale->name, 0, 2)) }}</span>
                                        </div>
                                        <div>
                                            <div class="text-white font-medium">{{ $sale->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-400">{{ $sale->category?->name ?? 'Uncategorized' }}</td>                                <td class="px-6 py-4 text-white font-medium">${{ number_format($sale->amount, 2) }}</td>
                                <td class="px-6 py-4 text-slate-400">{{ $sale->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('sales.edit', $sale) }}" 
                                           class="bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-400 px-3 py-2 rounded-lg text-sm flex items-center space-x-1 transition-colors duration-200">
                                            Edit
                                        </a>
                                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Are you sure you want to delete this sale?')"
                                                    class="bg-red-500/20 hover:bg-red-500/30 text-red-400 px-3 py-2 rounded-lg text-sm transition-colors duration-200">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    No sales found. <a href="{{ route('sales.create') }}" class="text-blue-400 hover:underline">Create your first sale</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination (Optional) -->
        <div class="mt-6">
            {{ $sales->links() }}
        </div>
    </div>
</div>
@endsection

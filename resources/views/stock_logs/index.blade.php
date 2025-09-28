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
                    <h1 class="text-3xl font-bold text-white mb-2">Stock Logs</h1>
                    <p class="text-slate-400">Track all stock in & out activity</p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-3 md:space-y-0">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('stock_logs.index') }}" class="flex space-x-2">
                    <select name="type"
                        class="px-4 py-2 rounded-lg bg-slate-800/50 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                        <option value="">All</option>
                        <option value="in" @selected(request('type') == 'in')>IN</option>
                        <option value="out" @selected(request('type') == 'out')>OUT</option>
                    </select>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        Filter
                    </button>
                </form>

                <!-- Export Button -->
                <div class="text-right">
                    <a href="{{ route('stock_logs.export', request()->query()) }}" 
   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-200">
    Export to Excel
</a>

                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-500/20 border border-green-500/50 text-green-300 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Stock Logs Table -->
            <div class="bg-slate-800/50 backdrop-blur-xl rounded-xl border border-slate-700/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-700/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">#</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Product</th>
                                <th class="px-6 py-4 text-sm font-semibold text-white text-center">Type</th>
                                <th class="px-6 py-4 text-sm font-semibold text-white text-center">Quantity</th>
                                <th class="px-6 py-4 text-sm font-semibold text-white text-center">Customer/Supplier</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Price</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($stockLogs as $index => $log)
                                <tr class="hover:bg-slate-700/30 transition-colors duration-200">
                                    <td class="px-6 py-4 text-white">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-white">{{ $log->product->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($log->type === 'in')
                                            <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-lg text-sm font-medium">IN</span>
                                        @else
                                            <span class="bg-red-500/20 text-red-400 px-3 py-1 rounded-lg text-sm font-medium">OUT</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center text-white">{{ $log->quantity }}</td>

                                    <!-- Customer/Supplier Column -->
                                    <td class="px-6 py-4 text-white text-center">
                                        @if($log->type === 'in')
                                            {{ $log->supplier->name ?? 'N/A' }}
                                        @else
                                            {{ $log->sale->customer_name ?? 'N/A' }}                                        
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-white">
                                        @if($log->type === 'in')
                                            ₱{{ number_format($log->buying_price ?? 0, 2) }}
                                        @else
                                            ₱{{ number_format($log->total_price ?? 0, 2) }}
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-slate-400">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                        No stock logs found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $stockLogs->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection

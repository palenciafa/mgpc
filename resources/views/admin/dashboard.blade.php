@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }
    </style>

    <div class="dashboard-container">
        <div class="bg-slate-900/90 px-6 py-8 min-h-screen">
            <div class="text-white">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-white mb-2">Admin Dashboard</h1>
                    <p class="text-slate-300 text-lg">Welcome, {{ auth()->user()->name }}</p>
                </div>

                <!-- Dashboard Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                    <!-- Products -->
                    <a href="{{ route('products.index') }}" class="block">
                        <div
                            class="bg-slate-800/50 rounded-xl p-6 border border-slate-700/50 hover:shadow-2xl hover:bg-slate-800/70 transition-all duration-300">
                            <div class="text-center">
                                <div class="flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-blue-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    <h3 class="text-lg font-semibold text-white">Products</h3>
                                </div>
                                <p class="text-4xl font-bold text-blue-400 counter mb-2" data-target="{{ $productsCount }}">
                                    0</p>
                                <p class="text-slate-400 text-sm">Manage your product catalog</p>
                            </div>
                        </div>
                    </a>

                    <!-- Suppliers -->
                    <a href="{{ route('suppliers.index') }}" class="block">
                        <div
                            class="bg-slate-800/50 rounded-xl p-6 border border-slate-700/50 hover:shadow-2xl hover:bg-slate-800/70 transition-all duration-300">
                            <div class="text-center">
                                <div class="flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-green-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <h3 class="text-lg font-semibold text-white">Suppliers</h3>
                                </div>
                                <p class="text-4xl font-bold text-green-400 counter mb-2"
                                    data-target="{{ $suppliersCount }}">0</p>
                                <p class="text-slate-400 text-sm">Active business partners</p>
                            </div>
                        </div>
                    </a>

                    <!-- Sales -->
                    <a href="{{ route('sales.index') }}" class="block">
                        <div
                            class="bg-slate-800/50 rounded-xl p-6 border border-slate-700/50 hover:shadow-2xl hover:bg-slate-800/70 transition-all duration-300">
                            <div class="text-center">
                                <div class="flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-red-400 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                    <h3 class="text-lg font-semibold text-white">Sales</h3>
                                </div>
                                <p class="text-4xl font-bold text-red-400 counter mb-2" data-target="{{ $salesCount }}">0
                                </p>
                                <p class="text-slate-400 text-sm">Track sales and revenue</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Total Stock Price IN vs OUT -->
                <h2 class="mt-10 mb-6 text-xl font-bold text-center">Total Price of Stock IN and OUT</h2>
                <div class="flex flex-col md:flex-row gap-6 items-start justify-center mb-8 max-w-6xl mx-auto">
                    <!-- Chart -->
                    <div class="bg-slate-800/50 backdrop-blur-xl rounded-xl border border-slate-700/50 p-6 flex-1">
                        <canvas id="stockPriceChart" height="200"></canvas>
                    </div>
                    <!-- Table -->
                    <div
                        class="bg-slate-800/50 backdrop-blur-xl rounded-xl border border-slate-700/50 p-6 flex-1 overflow-x-auto">
                        <table class="table-auto w-full text-white">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left">Type</th>
                                    <th class="px-4 py-2 text-left">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $purchase = $stockLogs->where('type', 'in')->sum('buying_price');
                                    $sale = $stockLogs->where('type', 'out')->sum('total_price');
                                    $profit = $sale - $purchase;
                                @endphp
                                <tr>
                                    <td class="px-4 py-2">Purchase (IN)</td>
                                    <td class="px-4 py-2">₱{{ number_format($purchase, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Sale (OUT)</td>
                                    <td class="px-4 py-2">₱{{ number_format($sale, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-bold">Profit</td>
                                    <td class="px-4 py-2 font-bold text-green-400">₱{{ number_format($profit, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <!-- Fast Moving Items -->
                <h2 class="mt-10 mb-6 text-xl font-bold text-center">Fast Moving Items (Most OUT)</h2>
                <div class="flex flex-col md:flex-row gap-6 items-start justify-center mb-8 max-w-6xl mx-auto">
                    <!-- Chart -->
                    <div class="bg-slate-800/50 backdrop-blur-xl rounded-xl border border-slate-700/50 p-6 flex-1">
                        <canvas id="fastMovingChart" height="200"></canvas>
                    </div>
                    <!-- Table -->
                    <div
                        class="bg-slate-800/50 backdrop-blur-xl rounded-xl border border-slate-700/50 p-6 flex-1 overflow-x-auto">
                        <table class="table-auto w-full text-white">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left">Product</th>
                                    <th class="px-4 py-2 text-left">Total Quantity Out</th>
                                    <th class="px-4 py-2 text-left">Total Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fastMovingItems as $item)
                                    <tr>
                                        <td class="px-4 py-2">{{ $item->name }}</td>
                                        <td class="px-4 py-2">{{ $item->total_out }}</td>
                                        <td class="px-4 py-2">₱{{ number_format($item->sales_sum_total_price, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-2">No fast moving items yet.</td>
                                    </tr>
                                @endforelse

                                @if($fastMovingItems->count() > 0)
                                    <tr class="font-bold border-t border-slate-600">
                                        <td class="px-4 py-2">Total</td>
                                        <td class="px-4 py-2">{{ $fastMovingItems->sum('total_out') }}</td>
                                        <td class="px-4 py-2">
                                            ₱{{ number_format($fastMovingItems->sum('sales_sum_total_price'), 2) }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Counter animation
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;
                    const increment = target / 50;
                    if (count < target) {
                        counter.innerText = Math.ceil(count + increment);
                        setTimeout(updateCount, 20);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount();
            });

            // Stock Price Chart
            const ctxStock = document.getElementById('stockPriceChart').getContext('2d');
            new Chart(ctxStock, {
                type: 'bar',
                data: {
                    labels: ['Purchase', 'Sale'],
                    datasets: [{
                        label: 'Total Price',
                        data: [
                        {{ $stockLogs->where('type', 'in')->sum('buying_price') }},
                            {{ $stockLogs->where('type', 'out')->sum('total_price') }}
                        ],
                        backgroundColor: ['rgba(239,68,68,0.7)', 'rgba(34,197,94,0.7)'],
                        borderColor: ['rgba(239,68,68,1)', 'rgba(34,197,94,1)'],
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            bodyColor: 'white',
                            titleColor: 'white',
                            backgroundColor: '#1e293b',
                            callbacks: {
                                label: function (context) {
                                    return `₱${context.raw.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: { ticks: { color: 'white' }, grid: { color: 'rgba(255,255,255,0.1)' } },
                        y: { ticks: { color: 'white' }, grid: { color: 'rgba(255,255,255,0.1)' } }
                    }
                }
            });

            // Fast Moving Items Chart
            const ctxFast = document.getElementById('fastMovingChart').getContext('2d');
            new Chart(ctxFast, {
                type: 'bar',
                data: {
                    labels: @json($fastMovingItems->pluck('name')),
                    datasets: [{
                        label: 'Total Quantity Out',
                        data: @json($fastMovingItems->pluck('total_out')),
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            bodyColor: 'white',
                            titleColor: 'white',
                            backgroundColor: '#1e293b',
                            callbacks: {
                                label: function (context) {
                                    return context.raw.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        x: { ticks: { color: 'white' }, grid: { color: 'rgba(255,255,255,0.1)' }, barPercentage: 0.6, categoryPercentage: 0.5 },
                        y: { ticks: { color: 'white' }, grid: { color: 'rgba(255,255,255,0.1)' } }
                    }
                }
            });
        });
    </script>
@endpush
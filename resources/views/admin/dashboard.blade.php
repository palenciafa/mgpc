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
            <!-- Page Title -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white mb-2">Admin Dashboard</h1>
                <p class="text-slate-300 text-lg">Welcome, {{ auth()->user()->name }}</p>
            </div>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                <!-- Products -->
                <a href="{{ route('products.index') }}" class="block">
                    <div class="bg-slate-800/50 rounded-xl p-6 border border-slate-700/50 hover:shadow-2xl hover:bg-slate-800/70 transition-all duration-300">
                        <div class="text-center">
                            <div class="flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <h3 class="text-lg font-semibold text-white">Products</h3>
                            </div>
                            <p class="text-4xl font-bold text-blue-400 counter mb-2" data-target="{{ $productsCount }}">0</p>
                            <p class="text-slate-400 text-sm">Manage your product catalog</p>
                        </div>
                    </div>
                </a>

                <!-- Suppliers -->
                <a href="{{ route('suppliers.index') }}" class="block">
                    <div class="bg-slate-800/50 rounded-xl p-6 border border-slate-700/50 hover:shadow-2xl hover:bg-slate-800/70 transition-all duration-300">
                        <div class="text-center">
                            <div class="flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <h3 class="text-lg font-semibold text-white">Suppliers</h3>
                            </div>
                            <p class="text-4xl font-bold text-green-400 counter mb-2" data-target="{{ $suppliersCount }}">0</p>
                            <p class="text-slate-400 text-sm">Active business partners</p>
                        </div>
                    </div>
                </a>

                <!-- Sales -->
                <a href="{{ route('sales.index') }}" class="block">
                    <div class="bg-slate-800/50 rounded-xl p-6 border border-slate-700/50 hover:shadow-2xl hover:bg-slate-800/70 transition-all duration-300">
                        <div class="text-center">
                            <div class="flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <h3 class="text-lg font-semibold text-white">Sales</h3>
                            </div>
                            <p class="text-4xl font-bold text-red-400 counter mb-2" data-target="{{ $salesCount }}">0</p>
                            <p class="text-slate-400 text-sm">Track sales and revenue</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Fast Moving Items Section --}}
            <h2 class="mt-10 text-xl font-bold">📈 Fast Moving Items (Most OUT)</h2>
            <canvas id="fastMovingChart" height="120"></canvas>

            <table class="table table-striped mt-3 text-white">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Total Out</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fastMovingItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->total_out }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2">No fast moving items yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
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

    // Chart.js
    const ctx = document.getElementById('fastMovingChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($fastMovingItems->pluck('product.name')),
            datasets: [{
                label: 'Total Out',
                data: @json($fastMovingItems->pluck('total_out')),
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Top Fast Moving Items'
                }
            },
            scales: { y: { beginAtZero: true } }
        }
    });
});
</script>
@endpush

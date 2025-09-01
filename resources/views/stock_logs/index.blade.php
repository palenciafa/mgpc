@extends('layouts.app')

@section('content')
<h1>Stock Logs</h1>

{{-- Stock Logs Table --}}
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse($stockLogs as $log)
        <tr>
            <td>{{ $log->product->name }}</td>
            <td>
                @if($log->type === 'in')
                    <span class="text-success">IN</span>
                @else
                    <span class="text-danger">OUT</span>
                @endif
            </td>
            <td>{{ $log->quantity }}</td>
            <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
        </tr>
        @empty
        <tr><td colspan="4">No stock logs found.</td></tr>
        @endforelse
    </tbody>
</table>

{{-- Fast Moving Items Section --}}
<h2 class="mt-4">📈 Fast Moving Items (Most OUT)</h2>
<canvas id="fastMovingChart" height="120"></canvas>

<table class="table table-striped mt-3">
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
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('fastMovingChart').getContext('2d');

    const fastMovingChart = new Chart(ctx, {
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
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection

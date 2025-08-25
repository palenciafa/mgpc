@extends('layouts.app')

@section('content')
<h1>Sales</h1>
<a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">+ New Sale</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Sale Price</th>
            <th>Total</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse($sales as $sale)
        <tr>
            <td>{{ $sale->product->name }}</td>
            <td>{{ $sale->quantity }}</td>
            <td>{{ number_format($sale->sale_price, 2) }}</td>
            <td>{{ number_format($sale->quantity * $sale->sale_price, 2) }}</td>
            <td>{{ $sale->created_at->format('Y-m-d') }}</td>
        </tr>
        @empty
        <tr><td colspan="5">No sales found.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection

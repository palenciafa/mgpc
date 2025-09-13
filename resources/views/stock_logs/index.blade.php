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
@endsection

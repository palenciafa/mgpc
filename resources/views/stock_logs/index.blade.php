@extends('layouts.app')

@section('content')
<h1>Stock Logs</h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th>Change</th>
            <th>Note</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse($stockLogs as $log)
        <tr>
            <td>{{ $log->product->name }}</td>
            <td>{{ $log->change > 0 ? '+' : '' }}{{ $log->change }}</td>
            <td>{{ $log->note }}</td>
            <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
        </tr>
        @empty
        <tr><td colspan="4">No stock logs found.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection

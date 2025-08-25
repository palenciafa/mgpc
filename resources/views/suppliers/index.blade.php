@extends('layouts.app')

@section('content')
<h1>Suppliers</h1>
<a href="{{ route('suppliers.create') }}" class="btn btn-primary mb-3">+ New Supplier</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @forelse($suppliers as $supplier)
    <tr>
        <td>{{ $supplier->name }}</td>
        <td>{{ $supplier->contact }}</td>
        <td>{{ $supplier->email }}</td>
        <td>{{ $supplier->address }}</td> <!-- Show address here -->
        <td>
            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" style="display:inline;">
                @csrf 
                @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this supplier?')">Delete</button>
            </form>
        </td>
    </tr>
    @empty
    <tr><td colspan="6">No suppliers found.</td></tr>
    @endforelse
</tbody>

</table>
@endsection

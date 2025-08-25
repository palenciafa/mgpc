@extends('layouts.app')

@section('content')
<h1>Products</h1>
<a href="{{ route('products.create') }}" class="btn btn-primary mb-3">+ New Product</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Supplier</th>
            <th>Stock</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name ?? 'N/A' }}</td>
            <td>{{ $product->supplier->name ?? 'N/A' }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->price }}</td>
            <td>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6">No products found.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection

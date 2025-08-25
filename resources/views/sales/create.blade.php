@extends('layouts.app')

@section('content')
<h1>New Sale</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif

<form action="{{ route('sales.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Product</label>
        <select name="product_id" class="form-control" required>
            <option value="">Select product</option>
            @foreach($products as $product)
            <option value="{{ $product->id }}" data-stock="{{ $product->stock }}">
                {{ $product->name }} (Stock: {{ $product->stock }})
            </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Quantity</label>
        <input type="number" name="quantity" min="1" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Sale Price</label>
        <input type="number" name="sale_price" step="0.01" min="0" class="form-control" required>
    </div>

    <button class="btn btn-primary">Record Sale</button>
    <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection

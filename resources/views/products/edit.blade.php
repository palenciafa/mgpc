@extends('layouts.app')

@section('content')
<h1>Edit Product</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif

<form action="{{ route('products.update', $product) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required value="{{ $product->name }}">
    </div>

    <div class="mb-3">
        <label>Category</label>
        <select name="category_id" class="form-control" required>
            <option value="">-- Choose Category --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @if($category->id == $product->category_id) selected @endif>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Supplier</label>
        <select name="supplier_id" class="form-control">
            <option value="">-- Optional --</option>
            @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}" @if($supplier->id == $product->supplier_id) selected @endif>
                    {{ $supplier->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Stock</label>
        <input type="number" name="stock" class="form-control" required value="{{ $product->stock }}">
    </div>

    <div class="mb-3">
        <lab

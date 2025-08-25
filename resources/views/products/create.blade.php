@extends('layouts.app') {{-- or your custom layout --}}
@section('content')
    <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Add New Product</h2>

        @if ($errors->any())
            <div class="mb-4 text-red-500">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('products.store') }}">
            @csrf

            <!-- Product Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" name="name" id="name" required
                       class="w-full mt-1 px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-indigo-200">
            </div>

            <!-- Category Selection -->
            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" id="category_id" required
                        class="w-full mt-1 px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                    <option value="">Select a Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Stock -->
            <div class="mb-4">
                <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                <input type="number" name="stock" id="stock" value="0" required
                       class="w-full mt-1 px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-indigo-200">
            </div>

            <!-- supplier -->
            <select name="supplier_id" id="supplier_id" required
                    class="w-full mt-1 px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                <option value="">Select a Supplier</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>

            

            <!-- Price -->
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" name="price" id="price" step="0.01" required
                       class="w-full mt-1 px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-indigo-200">
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Product</button>
        </form>
    </div>
@endsection

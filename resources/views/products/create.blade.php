@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        min-height: 100vh;
    }
</style>

<div class="min-h-screen bg-slate-900/90 px-6 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header with Back Button -->
        <div class="flex items-center mb-8">
            <a href="{{ route('products.index') }}" 
               class="mr-4 p-2 rounded-lg bg-slate-800/50 hover:bg-slate-700/50 text-slate-400 hover:text-white transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white mb-1">Add New Product</h1>
                <p class="text-slate-400">Create a new product</p>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-500/20 border border-red-500/50 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    <div>
                        <h3 class="text-red-300 font-medium mb-2">Please fix the following errors:</h3>
                        <ul class="text-red-400 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-slate-800/50 backdrop-blur-xl rounded-xl border border-slate-700/50 p-8">
            <form method="POST" action="{{ route('products.store') }}" class="space-y-6">
                @csrf
                
                <!-- Product Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-white mb-2">Product Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           placeholder="Enter product name..."
                           class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-colors duration-200">
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-white mb-2">Category</label>
                    <select name="category_id" id="category_id" required
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-colors duration-200">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Supplier -->
                <div>
                    <label for="supplier_id" class="block text-sm font-medium text-white mb-2">Supplier</label>
                    <select name="supplier_id" id="supplier_id" required
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-colors duration-200">
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-white mb-2">Stock</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required min="0"
                           placeholder="Enter stock quantity..."
                           class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-colors duration-200">
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-white mb-2">Price</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0" step="0.01"
                           placeholder="Enter product price..."
                           class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-colors duration-200">
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-700/50">
                    <a href="{{ route('products.index') }}" 
                       class="px-6 py-3 bg-slate-700/50 hover:bg-slate-600/50 text-slate-300 hover:text-white rounded-lg transition-colors duration-200 flex items-center space-x-2">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl">
                        Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

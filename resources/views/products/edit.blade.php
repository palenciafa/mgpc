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
                <h1 class="text-3xl font-bold text-white mb-1">Edit Product</h1>
                <p class="text-slate-400">Update product information</p>
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
            <form action="{{ route('products.update', $product) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Product Name Input -->
                <div>
                    <label for="name" class="block text-sm font-medium text-white mb-3">Product Name</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           required
                           value="{{ old('name', $product->name) }}"
                           placeholder="Enter product name..."
                           class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-colors duration-200">
                </div>

                <!-- Category Select -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-white mb-3">Category</label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-colors duration-200">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Price Input -->
                <div>
                    <label for="price" class="block text-sm font-medium text-white mb-3">Price</label>
                    <input type="number" 
                           name="price" 
                           id="price" 
                           required
                           step="0.01"
                           value="{{ old('price', $product->price) }}"
                           placeholder="Enter product price..."
                           class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-colors duration-200">
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-700/50">
                    <a href="{{ route('products.index') }}" 
                       class="px-6 py-3 bg-slate-700/50 hover:bg-slate-600/50 text-slate-300 hover:text-white rounded-lg transition-colors duration-200">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors duration-200">
                        Update Product
                    </button>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="mt-6 bg-red-500/10 border border-red-500/20 rounded-lg p-4">
            <h4 class="text-red-300 font-medium mb-1">Danger Zone</h4>
            <p class="text-red-400 text-sm mb-3">Once you delete a product, there is no going back. Please be certain.</p>
            <form action="{{ route('products.destroy', $product) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" 
                        onclick="return confirm('Are you sure you want to delete this product? This action cannot be undone.')"
                        class="bg-red-500/20 hover:bg-red-500/30 text-red-400 px-4 py-2 rounded-lg text-sm transition-colors duration-200">
                    Delete Product
                </button>
            </form>
        </div>

        <!-- Last Updated Info -->
        <div class="mt-4 text-center">
            <p class="text-slate-500 text-sm">
                @if($product->updated_at)
                    Last updated: {{ $product->updated_at->format('M d, Y \a\t g:i A') }}
                @else
                    Created: {{ $product->created_at->format('M d, Y \a\t g:i A') }}
                @endif
            </p>
        </div>
    </div>
</div>
@endsection

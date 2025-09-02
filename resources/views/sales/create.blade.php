@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        min-height: 100vh;
    }
</style>

<div class="min-h-screen px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Create New Sale</h1>
            <p class="text-slate-400">Fill out the form below to add a new sale.</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-500/20 border border-red-500/50 text-red-300 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <div class="bg-slate-800/50 backdrop-blur-xl rounded-xl border border-slate-700/50 p-6">
            <form action="{{ route('sales.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Customer Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-white mb-2">Customer Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="w-full px-4 py-2 rounded-lg bg-slate-700/50 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" 
                           placeholder="Enter customer name" required>
                </div>

                <!-- Product -->
                <div>
                    <label for="product_id" class="block text-sm font-medium text-white mb-2">Product</label>
                    <select name="product_id" id="product_id" required
                            class="w-full px-4 py-2 rounded-lg bg-slate-700/50 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                        <option value="">Select a product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Quantity -->
                <div>
                    <label for="quantity" class="block text-sm font-medium text-white mb-2">Quantity</label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" min="1"
                           class="w-full px-4 py-2 rounded-lg bg-slate-700/50 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" 
                           placeholder="Enter quantity" required>
                </div>

                <!-- Amount (Optional: can auto-calculate from product price) -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-white mb-2">Amount</label>
                    <input type="number" name="amount" id="amount" step="0.01" value="{{ old('amount') }}"
                           class="w-full px-4 py-2 rounded-lg bg-slate-700/50 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" 
                           placeholder="Enter sale amount" required>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <a href="{{ route('sales.index') }}" 
                       class="mr-4 px-4 py-2 rounded-lg bg-slate-600 hover:bg-slate-700 text-white transition duration-200">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 rounded-lg bg-blue-500 hover:bg-blue-600 text-white flex items-center space-x-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Create Sale</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

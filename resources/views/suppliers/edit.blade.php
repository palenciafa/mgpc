@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 to-slate-800 py-10 px-6">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-white mb-2">Edit Supplier</h1>
            <p class="text-slate-400">Update the supplier's information below</p>
        </div>

        <!-- Form Card -->
        <div class="bg-slate-800/50 backdrop-blur-xl rounded-2xl shadow-xl p-8 border border-slate-700/50">
            <form action="{{ route('suppliers.update', $supplier) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Supplier Name Input -->
                <div>
                    <label for="name" class="block text-sm font-medium text-white mb-3">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Supplier Name
                        </div>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           required
                           value="{{ old('name', $supplier->name) }}"
                           placeholder="Enter supplier name..."
                           class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-colors duration-200">
                </div>

                <!-- Contact Number -->
                <div>
                    <label for="contact" class="block text-sm font-medium text-white mb-3">Contact Number</label>
                    <input type="text" 
                           name="contact" 
                           id="contact"
                           value="{{ old('contact', $supplier->contact) }}"
                           placeholder="Enter contact number..."
                           class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-colors duration-200">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-white mb-3">Email</label>
                    <input type="email" 
                           name="email" 
                           id="email"
                           value="{{ old('email', $supplier->email) }}"
                           placeholder="Enter email..."
                           class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-colors duration-200">
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-white mb-3">Address</label>
                    <textarea name="address" 
                              id="address"
                              rows="3"
                              placeholder="Enter address..."
                              class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-colors duration-200">{{ old('address', $supplier->address) }}</textarea>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-700/50">
                    <a href="{{ route('suppliers.index') }}" 
                       class="px-6 py-3 bg-slate-700/50 hover:bg-slate-600/50 text-slate-300 hover:text-white rounded-lg transition-colors duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Cancel</span>
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        <span>Update Supplier</span>
                    </button>
                </div>
            </form>
        </div>
        <!-- Danger Zone -->
        <div class="mt-6 bg-red-500/10 border border-red-500/20 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <div class="flex-1">
                    <h4 class="text-red-300 font-medium mb-1">Danger Zone</h4>
                    <p class="text-red-400 text-sm mb-3">Once you delete a supplier, there is no going back. Please be certain.</p>
                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to delete this category? This action cannot be undone.')"
                                class="bg-red-500/20 hover:bg-red-500/30 text-red-400 px-4 py-2 rounded-lg text-sm transition-colors duration-200 flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span>Delete Supplier</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Last Updated Info -->
        <div class="mt-4 text-center">
            <p class="text-slate-500 text-sm">
                @if($supplier->updated_at)
                    Last updated: {{ $supplier->updated_at->format('M d, Y \a\t g:i A') }}
                @else
                    Created: {{ $supplier->created_at->format('M d, Y \a\t g:i A') }}
                @endif
            </p>
        </div>
    </div>
</div>
@endsection

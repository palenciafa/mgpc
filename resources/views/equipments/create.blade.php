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
            <a href="{{ route('equipments.index') }}" 
               class="mr-4 p-2 rounded-lg bg-slate-800/50 hover:bg-slate-700/50 text-slate-400 hover:text-white transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white mb-1">Add New Equipment</h1>
                <p class="text-slate-400">Record a new piece of equipment</p>
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
            <form method="POST" action="{{ route('equipments.store') }}" class="space-y-6">
                @csrf

                <!-- Brand Input -->
                <div>
                    <label for="brand" class="block text-sm font-medium text-white mb-3">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Brand
                        </div>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="brand" 
                               id="brand" 
                               required
                               value="{{ old('brand') }}"
                               placeholder="Enter brand (e.g., Makita, Bosch)..."
                               class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-colors duration-200">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-slate-400">Enter the brand of the equipment</p>
                </div>

                <!-- Equipment Name Input -->
                <div>
                    <label for="name" class="block text-sm font-medium text-white mb-3">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Equipment Name
                        </div>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="name" 
                               id="name" 
                               required
                               value="{{ old('name') }}"
                               placeholder="Enter equipment name..."
                               class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-colors duration-200">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-slate-400">Enter the name of the equipment</p>
                </div>

                <!-- Date Issued -->
                <div>
                    <label for="date_issued" class="block text-sm font-medium text-white mb-3">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Date Issued
                        </div>
                    </label>
                    <div class="relative">
                        <input type="date" 
                               name="date_issued" 
                               id="date_issued" 
                               value="{{ old('date_issued') }}"
                               class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-colors duration-200">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-slate-400">Enter the date when this equipment was issued</p>
                </div>

                <!-- Assigned Employee Select -->
                <div>
                    <label for="employee_id" class="block text-sm font-medium text-white mb-3">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Assign to Employee
                        </div>
                    </label>
                    <select name="employee_id" id="employee_id" 
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-colors duration-200">
                        <option value="">-- Select Employee --</option>
                        @foreach(\App\Models\Employee::all() as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-sm text-slate-400">Optionally assign this equipment to an employee</p>
                </div>

                <!-- Status -->
<div>
    <label for="status" class="block text-sm font-medium text-white mb-2">Status</label>
    <select name="status" id="status" class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white">
        @php $statuses = ['good condition','bad condition','for repair','lost']; @endphp
        @foreach ($statuses as $s)
            <option value="{{ $s }}" {{ old('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
</div>


                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-700/50">
                    <a href="{{ route('equipments.index') }}" 
                       class="px-6 py-3 bg-slate-700/50 hover:bg-slate-600/50 text-slate-300 hover:text-white rounded-lg transition-colors duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>Cancel</span>
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Save Equipment</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

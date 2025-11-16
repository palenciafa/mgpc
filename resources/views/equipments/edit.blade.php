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
                <h1 class="text-3xl font-bold text-white mb-1">Edit Equipment</h1>
                <p class="text-slate-400">Update equipment details</p>
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

            <!-- Equipment Info Header -->
            <div class="flex items-center mb-6 pb-6 border-b border-slate-700/50">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center mr-4">
                    <span class="text-white font-bold text-lg">{{ strtoupper(substr($equipment->name, 0, 2)) }}</span>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white">{{ $equipment->brand }} - {{ $equipment->name }}</h3>
                    <p class="text-slate-400 text-sm">Control #: {{ $equipment->control_number }}</p>
                </div>
            </div>

            <form action="{{ route('equipments.update', $equipment) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Brand -->
                <div>
                    <label for="brand" class="block text-sm font-medium text-white mb-3">Brand</label>
                    <input type="text" name="brand" id="brand" required
                           value="{{ old('brand', $equipment->brand) }}"
                           placeholder="Enter brand..."
                           class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-colors duration-200">
                </div>

                <!-- Equipment Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-white mb-3">Equipment Name</label>
                    <input type="text" name="name" id="name" required
                           value="{{ old('name', $equipment->name) }}"
                           placeholder="Enter equipment name..."
                           class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-colors duration-200">
                </div>

                <!-- Assigned Employee -->
                <div>
                    <label for="employee_id" class="block text-sm font-medium text-white mb-3">Assign Employee</label>
                    <select name="employee_id" id="employee_id"
                            class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition-colors duration-200">
                        <option value="">Unassigned</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" {{ $equipment->employee_id == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
<div>
    <label for="status" class="block text-sm font-medium text-white mb-2">Status</label>
    <select name="status" id="status" class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-lg text-white">
        @php $statuses = ['good condition','bad condition','for repair','lost']; @endphp
        @foreach ($statuses as $s)
            <option value="{{ $s }}" {{ old('status', $equipment->status) == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
</div>


                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-slate-700/50">
                    <a href="{{ route('equipments.index') }}" 
                       class="px-6 py-3 bg-slate-700/50 hover:bg-slate-600/50 text-slate-300 hover:text-white rounded-lg transition-colors duration-200 flex items-center space-x-2">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl">
                        Update Equipment
                    </button>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="mt-6 bg-red-500/10 border border-red-500/20 rounded-lg p-4">
            <div class="flex items-start">
                <div class="flex-1">
                    <h4 class="text-red-300 font-medium mb-1">Danger Zone</h4>
                    <p class="text-red-400 text-sm mb-3">Once you delete this equipment, there is no going back.</p>
                    <form action="{{ route('equipments.destroy', $equipment) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to delete this equipment?')"
                                class="bg-red-500/20 hover:bg-red-500/30 text-red-400 px-4 py-2 rounded-lg text-sm transition-colors duration-200 flex items-center space-x-2">
                            Delete Equipment
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Last Updated Info -->
        <div class="mt-4 text-center">
            <p class="text-slate-500 text-sm">
                @if($equipment->updated_at)
                    Last updated: {{ $equipment->updated_at->format('M d, Y \a\t g:i A') }}
                @else
                    Created: {{ $equipment->created_at->format('M d, Y \a\t g:i A') }}
                @endif
            </p>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
        }
    </style>

    <div class="min-h-screen bg-slate-900/90 px-6 py-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Equipments</h1>
                    <p class="text-slate-400">Manage your equipments and assigned employees</p>
                </div>
            </div>

            <!-- Search Bar -->
            <form method="GET" action="{{ route('equipments.index') }}"
                class="flex flex-col md:flex-row items-center justify-between mb-6 space-y-3 md:space-y-0">
                <input type="text" name="search" placeholder="Search equipments..." value="{{ request('search') }}"
                    class="w-full md:w-1/3 px-4 py-2 rounded-lg bg-slate-800/50 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                <div class="flex space-x-2">
                    <a href="{{ route('equipments.create') }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg flex items-center space-x-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>New Equipment</span>
                    </a>
                </div>
            </form>

            @if(session('success'))
                <div class="bg-green-500/20 border border-green-500/50 text-green-300 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="bg-slate-800/50 backdrop-blur-xl rounded-xl border border-slate-700/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-700/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Control Number</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Equipment Name</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Assigned Employee</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($equipments as $equipment)
                                <tr class="hover:bg-slate-700/30 transition-colors duration-200">
                                    <td class="px-6 py-4 text-white font-medium">{{ $equipment->control_number }}</td>

                                    <!-- ✅ FIXED: Display "Brand - Name" -->
                                    <td class="px-6 py-4 text-white font-medium">
                                        {{ $equipment->brand }} - {{ $equipment->name }}
                                    </td>

                                    <td class="px-6 py-4 text-slate-400">
                                        {{ $equipment->employee ? $equipment->employee->name : 'Unassigned' }}
                                    </td>
                                    <td class="px-6 py-4">
    @php
        $statusColors = [
            'good condition' => 'bg-green-500/20 hover:bg-green-500/30 text-green-500',
            'bad condition'       => 'bg-red-500/20 hover:bg-red-500/30 text-red-500',
            'for repair'          => 'bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-500',
            'lost'                => 'bg-gray-500/20 hover:bg-gray-500/30 text-gray-500',
        ];
        $statusClass = $statusColors[$equipment->status] ?? 'bg-slate-500/20 hover:bg-slate-500/30 text-slate-500';
    @endphp
    <span class="px-3 py-2 rounded-lg text-sm font-medium flex items-center justify-center transition-colors duration-200 {{ $statusClass }}">
        {{ ucfirst($equipment->status) }}
    </span>
</td>




                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('equipments.edit', $equipment) }}"
                                                class="bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-400 px-3 py-2 rounded-lg text-sm flex items-center space-x-1 transition-colors duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                <span>Edit</span>
                                            </a>
                                            <form action="{{ route('equipments.destroy', $equipment) }}" method="POST"
                                                class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this equipment?')"
                                                    class="bg-red-500/20 hover:bg-red-500/30 text-red-400 px-3 py-2 rounded-lg text-sm flex items-center space-x-1 transition-colors duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    <span>Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-slate-600 mb-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            <h3 class="text-slate-400 text-lg font-medium mb-2">No equipments found</h3>
                                            <p class="text-slate-500 text-sm mb-4">Get started by adding your first equipment.
                                            </p>
                                            <a href="{{ route('equipments.create') }}"
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                                                Add Equipment
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

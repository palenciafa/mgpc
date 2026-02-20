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
                <div class="w-full md:w-1/3 relative">
                    <input type="text" name="search" placeholder="Search equipments..." value="{{ request('search') }}"
                        class="w-full px-4 py-2 pl-10 rounded-lg bg-slate-800/50 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                    <svg class="w-5 h-5 absolute left-3 top-2.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
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
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Date Issued</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Assigned Employee</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($equipments as $equipment)
                                <tr class="hover:bg-slate-700/30 transition-colors duration-200">
                                    <td class="px-6 py-4 text-white font-medium">{{ $equipment->control_number }}</td>
                                    <td class="px-6 py-4 text-white font-medium">{{ $equipment->brand }} -
                                        {{ $equipment->name }}</td>
                                    <td class="px-6 py-4 text-slate-400">{{ $equipment->date_issued ? $equipment->date_issued->format('m/d/Y') : 'N/A' }}</td>
                                    <td class="px-6 py-4 text-slate-400">
                                        {{ $equipment->employee ? $equipment->employee->name : 'Unassigned' }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColors = [
                                                'good condition' => 'bg-green-500/20 hover:bg-green-500/30 text-green-500',
                                                'bad condition' => 'bg-red-500/20 hover:bg-red-500/30 text-red-500',
                                                'for repair' => 'bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-500',
                                                'lost' => 'bg-gray-500/20 hover:bg-gray-500/30 text-gray-500',
                                            ];
                                            $statusClass = $statusColors[$equipment->status] ?? 'bg-slate-500/20 hover:bg-slate-500/30 text-slate-500';
                                        @endphp
                                        <span
                                            class="px-3 py-2 rounded-lg text-sm font-medium flex items-center justify-center transition-colors duration-200 {{ $statusClass }}">
                                            {{ ucfirst($equipment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('equipments.edit', $equipment) }}"
                                                class="bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-400 px-3 py-2 rounded-lg text-sm flex items-center space-x-1 transition-colors duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                <span>Edit</span>
                                            </a>

                                            <!-- Upload Image Button -->
                                            <button type="button"
                                                class="bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 px-3 py-2 rounded-lg text-sm flex items-center space-x-1 transition-colors duration-200 upload-button"
                                                data-name="{{ $equipment->name }}" data-brand="{{ $equipment->brand }}"
                                                data-image="{{ $equipment->image }}"
                                                data-upload-url="{{ route('equipments.uploadImage', $equipment) }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                                </svg>
                                                <span>Upload</span>
                                            </button>

                                            <form action="{{ route('equipments.destroy', $equipment) }}" method="POST"
                                                class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this equipment?')"
                                                    class="bg-red-500/20 hover:bg-red-500/30 text-red-400 px-3 py-2 rounded-lg text-sm flex items-center space-x-1 transition-colors duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    <span>Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-slate-600 mb-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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

    <!-- Equipment Image Modal -->
    <div id="equipmentModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-slate-800 rounded-xl shadow-lg p-6 w-full max-w-md">
            <h2 class="text-xl font-semibold text-white mb-4" id="modalEquipmentName">Equipment</h2>

            <!-- Image Preview -->
            <div class="mb-4">
                <img id="modalEquipmentImage" src="" alt="Equipment Image"
                    class="w-full h-64 object-contain rounded-lg bg-slate-700">
            </div>

            <!-- Upload Form -->
            <form id="modalUploadForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="image" id="modalImageInput" accept="image/png, image/jpeg" class="hidden">

                <button type="button" id="browseButton"
                    class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-500 mb-2">Select Image</button>

                <button type="button" onclick="equipmentModal.classList.add('hidden')"
                    class="w-full px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-500">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        const equipmentModal = document.getElementById('equipmentModal');
        const modalEquipmentName = document.getElementById('modalEquipmentName');
        const modalEquipmentImage = document.getElementById('modalEquipmentImage');
        const modalUploadForm = document.getElementById('modalUploadForm');
        const modalImageInput = document.getElementById('modalImageInput');
        const browseButton = document.getElementById('browseButton');

        document.querySelectorAll('.upload-button').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                const name = this.dataset.name;
                const brand = this.dataset.brand;
                const image = this.dataset.image;
                const uploadUrl = this.dataset.uploadUrl;

                modalEquipmentName.textContent = brand + ' - ' + name;
                modalUploadForm.action = uploadUrl;

                if (image) {
                    modalEquipmentImage.src = '/storage/' + image;
                } else {
                    modalEquipmentImage.src = '/images/placeholder.png';
                }

                equipmentModal.classList.remove('hidden');
            });
        });

        browseButton.addEventListener('click', () => {
            modalImageInput.click();
        });

        modalImageInput.addEventListener('change', () => {
            if (modalImageInput.files.length > 0) {
                modalUploadForm.submit();
            }
        });
    </script>

@endsection
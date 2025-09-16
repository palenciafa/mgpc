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
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Suppliers</h1>
                <p class="text-slate-400">Manage your Suppliers</p>
            </div>
            <a href="{{ route('suppliers.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg flex items-center space-x-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>New Supplier</span>
            </a>
        </div>

        <!-- Success Message -->
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

        <!-- Suppliers Table -->
        <div class="bg-slate-800/50 backdrop-blur-xl rounded-xl border border-slate-700/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Name</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @forelse($suppliers as $supplier)
                            <tr class="hover:bg-slate-700/30 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center mr-3">
                                            <span
                                                class="text-white font-semibold text-sm">{{ strtoupper(substr($supplier->name, 0, 2)) }}</span>
                                        </div>
                                        <div>
                                            <div class="text-white font-medium">{{ $supplier->name }}</div>
                                            <div class="text-slate-400 text-sm">Supplier ID: #{{ $supplier->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <!-- View Button -->
                                        <button type="button" onclick="openModal({{ $supplier->id }})"
                                            class="bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 px-3 py-2 rounded-lg text-sm flex items-center space-x-1 transition-colors duration-200">
                                            <span>View</span>
                                        </button>

                                        <!-- Edit Button -->
                                        <a href="{{ route('suppliers.edit', $supplier) }}"
                                            class="bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-400 px-3 py-2 rounded-lg text-sm flex items-center space-x-1 transition-colors duration-200">
                                            <span>Edit</span>
                                        </a>

                                        <!-- Transactions Button -->
                                        <button type="button" onclick="openTransactionsModal({{ $supplier->id }})"
                                            class="bg-purple-500/20 hover:bg-purple-500/30 text-purple-400 px-3 py-2 rounded-lg text-sm flex items-center space-x-1 transition-colors duration-200">
                                            <span>Transactions</span>
                                        </button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this supplier?')"
                                                class="bg-red-500/20 hover:bg-red-500/30 text-red-400 px-3 py-2 rounded-lg text-sm flex items-center space-x-1 transition-colors duration-200">
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-12 text-center text-slate-400">
                                    No suppliers found. Add your first supplier.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Supplier Details Modal -->
    <div id="detailsModal" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50">
        <div class="bg-slate-800 rounded-xl shadow-lg w-full max-w-md p-6 relative">
            <button onclick="closeModal()" class="absolute top-3 right-3 text-slate-400 hover:text-white">✖</button>
            <h2 class="text-xl font-bold text-white mb-4">Supplier Details</h2>
            <div id="modalContent" class="space-y-3 text-slate-300"></div>
        </div>
    </div>

    <!-- Transactions Modal -->
    <div id="transactionsModal" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50">
        <div class="bg-slate-800 rounded-xl shadow-lg w-full max-w-lg p-6 relative">
            <button onclick="closeTransactionsModal()" class="absolute top-3 right-3 text-slate-400 hover:text-white">✖</button>
            <h2 class="text-xl font-bold text-white mb-4">Supplier Transactions</h2>
            <div id="transactionsContent" class="overflow-y-auto max-h-96"></div>
        </div>
    </div>

    <script>
        const suppliers = @json($suppliers);

        // Supplier Details Modal
        function openModal(id) {
            const supplier = suppliers.find(s => s.id === id);
            if (!supplier) return;

            document.getElementById('modalContent').innerHTML = `
                <p><strong>Name:</strong> ${supplier.name}</p>
                <p><strong>Contact:</strong> ${supplier.contact ?? 'N/A'}</p>
                <p><strong>Email:</strong> ${supplier.email ?? 'N/A'}</p>
                <p><strong>Phone:</strong> ${supplier.phone ?? 'N/A'}</p>
                <p><strong>Address:</strong> ${supplier.address ?? 'N/A'}</p>
            `;

            document.getElementById('detailsModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('detailsModal').classList.add('hidden');
        }

        // Transactions Modal
        function openTransactionsModal(id) {
            const supplier = suppliers.find(s => s.id === id);
            if (!supplier) return;

            const transactionsList = supplier.stock_logs.length
                ? `<table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-700/50">
                            <th class="px-3 py-1 text-white">Product Name</th>
                            <th class="px-3 py-1 text-white">Quantity</th>
                            <th class="px-3 py-1 text-white">Buying Price</th>
                            <th class="px-3 py-1 text-white">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${supplier.stock_logs.map(t => `
                            <tr class="border-t border-slate-700/50 text-slate-300">
                                <td class="px-3 py-1">${t.product?.name ?? 'N/A'}</td>
                                <td class="px-3 py-1">${t.quantity}</td>
                                <td class="px-3 py-1">${t.buying_price ?? '-'}</td>
                                <td class="px-3 py-1">${new Date(t.created_at).toLocaleString()}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>`
                : '<p class="text-slate-300">No transactions found for this supplier.</p>';

            document.getElementById('transactionsContent').innerHTML = transactionsList;
            document.getElementById('transactionsModal').classList.remove('hidden');
        }

        function closeTransactionsModal() {
            document.getElementById('transactionsModal').classList.add('hidden');
        }
    </script>
</div>
@endsection

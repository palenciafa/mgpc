<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MGPC Company - Modern Navigation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <nav x-data="{ open: false }" class="bg-slate-900/90 backdrop-blur-xl border-b border-slate-700/50 shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-4">
                    <a href="/admin/dashboard" class="text-xl font-bold text-white tracking-tight">
                        MGPC Company
                    </a>

                    <!-- Navigation Links -->
                    <div class="hidden lg:flex lg:ml-12 space-x-1">
                        <a href="/employees"
                            class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                            Employees
                        </a>
                        <a href="/categories"
                            class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                            Categories
                        </a>
                        @if(auth()->check() && auth()->user()->role === 'owner')
                            <a href="/suppliers"
                                class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                                Suppliers
                            </a>
                        @endif
                        <a href="/products"
                            class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                            Products
                        </a>
                        <a href="/equipments"
                            class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                            Equipments
                        </a>
                        <a href="/sales"
                            class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                            Sales
                        </a>
                        <a href="/stock-logs"
                            class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                            Stock Reports
                        </a>
                    </div>
                </div>

                <!-- Right Side Icons & User -->
                <div class="hidden lg:flex lg:items-center lg:space-x-4">
                    <div class="relative [9999]">
                        <button id="notifBtn"
                            class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all duration-200 relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if($lowStockCount > 0)
                                <span
                                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                    {{ $lowStockCount }}
                                </span>
                            @endif
                        </button>

                        <!-- Dropdown -->
                        <div id="notifDropdown"
                            class="absolute right-0 mt-2 w-72 bg-slate-800/90 rounded-lg shadow-lg overflow-hidden hidden z-[9999]">
                            <div class="p-4 text-white font-medium border-b border-slate-700/50">
                                Low Stock Products
                            </div>
                            <ul class="text-white max-h-60 overflow-y-auto">
                                @forelse($lowStockProducts as $product)
                                    <li class="px-4 py-2 hover:bg-slate-700/50 transition-colors flex justify-between">
                                        <span>{{ $product->name }}</span>
                                        <span class="{{ $product->stock >= 50 ? 'text-yellow-400' : 'text-red-400' }}">
                                            {{ $product->stock }}
                                        </span>
                                    </li>
                                @empty
                                    <li class="px-4 py-2 text-slate-400">No low-stock products</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen"
                            class="flex items-center space-x-3 p-2 rounded-lg hover:bg-slate-800/50 transition-all duration-200">
                            <span class="text-sm font-medium text-white">Admin</span>
                            <svg class="ml-1 w-4 h-4 text-slate-400" :class="{ 'rotate-180': dropdownOpen }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            @click.away="dropdownOpen = false"
                            class="dropdown-menu absolute right-0 mt-2 w-64 rounded-xl shadow-xl py-2 z-50">
                            <div class="border-t border-slate-600/50 mt-2 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center w-full px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-slate-800/50 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Sign Out
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const toggle = document.getElementById('darkModeToggle');
                            const html = document.documentElement;

                            // Load preference
                            if (localStorage.getItem('darkMode') === 'true') {
                                html.classList.add('dark');
                            }

                            toggle.addEventListener('click', () => {
                                html.classList.toggle('dark');
                                localStorage.setItem('darkMode', html.classList.contains('dark'));
                            });
                        });
                    </script>

                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden flex items-center">
                    <button @click="open = !open"
                        class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open }" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open }" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden lg:hidden">
            <div class="px-6 py-4 space-y-2 bg-slate-900/95 backdrop-blur-xl border-t border-slate-700/50">
                <a href="/admin/dashboard"
                    class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                    Dashboard
                </a>
                <a href="/employees"
                    class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                    Employees
                </a>
                <a href="/categories"
                    class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                    Categories
                </a>
                @if(auth()->check() && auth()->user()->role === 'owner')
                    <a href="/suppliers"
                        class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                        Suppliers
                    </a>
                @endif
                <a href="/products"
                    class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                    Products
                </a>
                <a href="/sales"
                    class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                    Sales
                </a>
                <a href="/stock-logs"
                    class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                    Stock Logs
                </a>
            </div>
        </div>
    </nav>
    <script>
        const notifBtn = document.getElementById('notifBtn');
        const notifDropdown = document.getElementById('notifDropdown');

        notifBtn.addEventListener('click', () => {
            notifDropdown.classList.toggle('hidden');
        });

        // Click outside to close
        document.addEventListener('click', function (event) {
            if (!notifBtn.contains(event.target) && !notifDropdown.contains(event.target)) {
                notifDropdown.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
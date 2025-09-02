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
                    <div class="logo-icon">
                        M
                    </div>
                    <a href="/admin" class="text-xl font-bold text-white tracking-tight">
                        MGPC Company
                    </a>

                    <!-- Navigation Links -->
                    <div class="hidden lg:flex lg:ml-12 space-x-1">
                        <a href="/admin/dashboard" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                            Dashboard
                        </a>
                        <a href="/categories" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                            Categories
                        </a>
                        <a href="/suppliers" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                            Suppliers
                        </a>
                        <a href="/products" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                            Products
                        </a>
                        <a href="/sales" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                            Sales
                        </a>
                        <a href="/stock-logs" class="nav-link px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                            Stock Logs
                        </a>
                    </div>
                </div>

                <!-- Right Side Icons & User -->
                <div class="hidden lg:flex lg:items-center lg:space-x-4">
                    <!-- Search Icon -->
                    <button class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>

                    <!-- Messages Icon -->
                    <button class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 3.26a2 2 0 001.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </button>

                    <!-- Notifications Icon -->
                    <button class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50 transition-all duration-200 relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                    </button>

                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-slate-800/50 transition-all duration-200">
                            <div class="user-avatar w-8 h-8 rounded-lg flex items-center justify-center text-white text-sm font-medium">
                                J
                            </div>
                            <span class="text-sm font-medium text-white">Admin</span>
                            <svg class="ml-1 w-4 h-4 text-slate-400" :class="{ 'rotate-180': dropdownOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="dropdownOpen" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             @click.away="dropdownOpen = false"
                             class="dropdown-menu absolute right-0 mt-2 w-64 rounded-xl shadow-xl py-2 z-50">
                            
                            <!-- <div class="px-4 py-3 border-b border-slate-600/50">
                                <div class="flex items-center space-x-3">
                                    <div class="user-avatar w-10 h-10 rounded-lg flex items-center justify-center text-white font-medium">
                                        J
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-white">John Doe</p>
                                        <p class="text-xs text-slate-400">john@mgpccompany.com</p>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="/profile" class="flex items-center px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-slate-800/50 transition-colors">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile Settings
                            </a>
                            <a href="/settings" class="flex items-center px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-slate-800/50 transition-colors">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Account Settings
                            </a> -->
                            <div class="border-t border-slate-600/50 mt-2 pt-2">
                                <button class="flex items-center w-full px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-slate-800/50 transition-colors">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Sign Out
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Dark Mode Toggle -->
                    <button id="darkModeToggle"
                        class="ml-4 px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded shadow hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        🌙 / ☀️
                    </button>
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const toggle = document.getElementById('darkModeToggle');
                            const html = document.documentElement;

                            // Load preference
                            if(localStorage.getItem('darkMode') === 'true'){
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
                    <button @click="open = !open" class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800/50">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden lg:hidden">
            <div class="px-6 py-4 space-y-2 bg-slate-900/95 backdrop-blur-xl border-t border-slate-700/50">
                <a href="/admin/dashboard" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                    Dashboard
                </a>
                <a href="/categories" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                    Categories
                </a>
                <a href="/suppliers" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                    Suppliers
                </a>
                <a href="/products" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                    Products
                </a>
                <a href="/sales" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                    Sales
                </a>
                <a href="/stock-logs" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/50">
                    Stock Logs
                </a>

                <!-- <div class="border-t border-slate-700/50 mt-4 pt-4">
                    <div class="flex items-center space-x-3 px-3 py-2">
                        <div class="user-avatar w-8 h-8 rounded-lg flex items-center justify-center text-white text-sm font-medium">
                            J
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">John Doe</p>
                            <p class="text-xs text-slate-400">john@mgpccompany.com</p>
                        </div>
                    </div>
                    <a href="/profile" class="block px-3 py-2 mt-2 rounded-lg text-sm text-slate-300 hover:text-white hover:bg-slate-800/50">
                        Profile Settings
                    </a>
                    <button class="block w-full text-left px-3 py-2 rounded-lg text-sm text-slate-300 hover:text-white hover:bg-slate-800/50">
                        Sign Out
                    </button>
                </div> -->
            </div>
        </div>
    </nav>

</body>
</html>
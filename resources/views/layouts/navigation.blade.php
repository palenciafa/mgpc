<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-1xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ url('/admin') }}" class="text-lg font-semibold text-gray-900 dark:text-white">
                    MGPC Company
                </a>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:ml-10 sm:flex">
                    <a href="{{ route('dashboard') }}" class="text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-blue-500' : 'text-gray-500 hover:text-gray-700' }}">
                        Admin Panel
                    </a>
                    <a href="{{ route('categories.index') }}" class="text-sm font-medium {{ request()->routeIs('products.*') ? 'text-blue-500' : 'text-gray-500 hover:text-gray-700' }}">
                        Categories
                    </a>
                    <a href="{{ route('suppliers.index') }}" class="text-sm font-medium {{ request()->routeIs('products.*') ? 'text-blue-500' : 'text-gray-500 hover:text-gray-700' }}">
                        Supplier
                    </a>
                    <a href="{{ route('products.index') }}" class="text-sm font-medium {{ request()->routeIs('products.*') ? 'text-blue-500' : 'text-gray-500 hover:text-gray-700' }}">
                        Products
                    </a>
                    <a href="{{ route('sales.index') }}" class="text-sm font-medium {{ request()->routeIs('sales.*') ? 'text-blue-500' : 'text-gray-500 hover:text-gray-700' }}">
                        Sales
                    </a>
                    <a href="{{ route('stock_logs.index') }}" class="text-sm font-medium {{ request()->routeIs('stock_logs.*') ? 'text-blue-500' : 'text-gray-500 hover:text-gray-700' }}">
                        Stock Logs
                    </a>
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center">
                <div class="relative" x-data="{ dropdownOpen: false }">
                    <button @click="dropdownOpen = !dropdownOpen" class="flex items-center text-sm font-medium text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white focus:outline-none">
                        {{ Auth::user()->name }}
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg py-1 z-20">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="sm:hidden flex items-center">
                <button @click="open = !open"
                        class="text-gray-400 hover:text-gray-500 dark:hover:text-white focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden px-4 pb-4">
        <a href="{{ route('dashboard') }}" class="block py-2 text-sm text-gray-700 dark:text-gray-200">
            Dashboard
        </a>
        <a href="{{ route('products.index') }}" class="block py-2 text-sm text-gray-700 dark:text-gray-200">
            Products
        </a>
        <a href="{{ route('sales.index') }}" class="block py-2 text-sm text-gray-700 dark:text-gray-200">
            Sales
        </a>
        <a href="{{ route('stock_logs.index') }}" class="block py-2 text-sm text-gray-700 dark:text-gray-200">
            Stock Logs
        </a>

        <div class="border-t border-gray-200 dark:border-gray-600 mt-2 pt-2">
            <div class="text-sm text-gray-700 dark:text-gray-200">
                {{ Auth::user()->name }}<br>
                {{ Auth::user()->email }}
            </div>
            <a href="{{ route('profile.edit') }}" class="block mt-2 text-sm text-gray-700 dark:text-gray-200">
                Profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block mt-2 text-sm text-gray-700 dark:text-gray-200">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</nav>

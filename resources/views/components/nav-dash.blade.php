<!-- resources/views/layouts/navdash.blade.php -->
<div class="flex h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <!-- Sidebar -->
    <div class="bg-white dark:bg-gray-900 shadow-lg border-r dark:border-gray-700 text-gray-800 dark:text-white transition-all duration-300 flex flex-col">
        <!-- Logo and Toggle -->
        @php
            use App\Models\Setting;
        @endphp
        <div class="px-6 py-2.5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <a href="/">
                <div class="flex items-center">
                    <img src="{{ asset('storage/' . Setting::get('site_logo')) }}" alt="Logo" class="h-10 w-auto">
                    <span class="ml-3 text-xl font-bold transition-opacity duration-300">{{ Setting::get('site_name', 'Jasa Amanah') }}</span>
                </div>
            </a>
        </div>

        <!-- Navigation Links -->
        <nav class="mt-3 flex-grow space-y-1 px-2">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
                class="{{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 dark:bg-blue-800/30 dark:text-blue-400 border-l-4 border-blue-600' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }} flex py-3 px-4 rounded-lg transition-colors duration-200 group">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                    <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h240v-560H200v560Zm320 0h240v-280H520v280Zm0-360h240v-200H520v200Z" />
                </svg>
                <span class="ml-3 transition-opacity duration-300">Dashboard</span>
            </a>

            <!-- Admin-only Links -->
            @if (Auth::user()->hasRole('admin'))
                <a href="{{ route('admin.users.index') }}"
                    class="{{ request()->routeIs('admin.users.index') ? 'bg-blue-50 text-blue-700 dark:bg-blue-800/30 dark:text-blue-400 border-l-4 border-blue-600' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }} flex py-3 px-4 rounded-lg transition-colors duration-200 group">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="ml-3 transition-opacity duration-300">Users</span>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                    class="{{ request()->routeIs('admin.orders.index') ? 'bg-blue-50 text-blue-700 dark:bg-blue-800/30 dark:text-blue-400 border-l-4 border-blue-600' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }} flex py-3 px-4 rounded-lg transition-colors duration-200 group">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="ml-3 transition-opacity duration-300">Orders</span>
                </a>

                <a href="{{ route('admin.tasks.index') }}"
                    class="{{ request()->routeIs('admin.tasks.index') ? 'bg-blue-50 text-blue-700 dark:bg-blue-800/30 dark:text-blue-400 border-l-4 border-blue-600' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }} flex py-3 px-4 rounded-lg transition-colors duration-200 group">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-3 5h3m-6 0h.01M12 16h3m-6 0h.01M10 3v4h4V3h-4Z" />
                    </svg>
                    <span class="ml-3 transition-opacity duration-300">Tasks</span>
                </a>

                <a href="{{ route('admin.services.index') }}"
                    class="{{ request()->routeIs('admin.services.index') ? 'bg-blue-50 text-blue-700 dark:bg-blue-800/30 dark:text-blue-400 border-l-4 border-blue-600' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }} flex py-3 px-4 rounded-lg transition-colors duration-200 group">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"></path>
                    </svg>
                    <span class="ml-3 transition-opacity duration-300">Services</span>
                </a>

                <a href="{{ url('/admin') }}"
                    class="{{ request()->is('admin') ? 'bg-blue-50 text-blue-700 dark:bg-blue-800/30 dark:text-blue-400 border-l-4 border-blue-600' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }} flex py-3 px-4 rounded-lg transition-colors duration-200 group">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="ml-3 transition-opacity duration-300">Analytics</span>
                </a>
            @endif

            <!-- Worker-only Links -->
            @if (Auth::user()->hasRole('worker'))
                <a href="{{ route('worker.orders.index') }}"
                    class="{{ request()->routeIs('worker.orders.index') ? 'bg-blue-50 text-blue-700 dark:bg-blue-800/30 dark:text-blue-400 border-l-4 border-blue-600' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }} flex py-3 px-4 rounded-lg transition-colors duration-200 group">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="ml-3 transition-opacity duration-300">Orders</span>
                </a>

                <a href="{{ route('worker.tasks.index') }}"
                    class="{{ request()->routeIs('worker.tasks.index') ? 'bg-blue-50 text-blue-700 dark:bg-blue-800/30 dark:text-blue-400 border-l-4 border-blue-600' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }} flex py-3 px-4 rounded-lg transition-colors duration-200 group">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-3 5h3m-6 0h.01M12 16h3m-6 0h.01M10 3v4h4V3h-4Z" />
                    </svg>
                    <span class="ml-3 transition-opacity duration-300">Tasks</span>
                </a>
            @endif

            <!-- System Section -->
            <div class="px-3 py-2 mt-6">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">System</h3>
            </div>

            <a href="{{ Auth::user()->hasRole('admin') ? route('settings.index') : route('worker.settings.index') }}"
                class="{{ request()->routeIs('settings.index') || request()->routeIs('worker.settings.index') ? 'bg-blue-50 text-blue-700 dark:bg-blue-800/30 dark:text-blue-400 border-l-4 border-blue-600' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }} flex py-3 px-4 rounded-lg transition-colors duration-200 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="ml-3 transition-opacity duration-300">Settings</span>
            </a>

            <a href="{{ route('help') }}"
                class="{{ request()->routeIs('help') ? 'bg-blue-50 text-blue-700 dark:bg-blue-800/30 dark:text-blue-400 border-l-4 border-blue-600' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }} flex py-3 px-4 rounded-lg transition-colors duration-200 group">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="ml-3 transition-opacity duration-300">Help</span>
            </a>
        </nav>

        <!-- User Profile -->
        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full object-cover"
                        src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('storage/default-avatar.jpg') }}"
                        alt="User profile">
                </div>
                <div class="ml-3 transition-opacity duration-300">
                    <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Navbar -->
        <header class="bg-white dark:bg-gray-900 shadow-sm border-b border-gray-200 dark:border-gray-700 py-3 px-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white lg:ml-0 ml-4">
                {{ $title }}
            </h1>
            <div class="flex items-center space-x-4">
                <!-- Notification Bell -->
                <div class="relative">
                    <button id="notification-toggle" class="relative text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <div id="unread-indicator" class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500 hidden"></div>
                    </button>

                    <!-- Notifications Dropdown -->
                    <div id="notification-dropdown" class="absolute z-10 hidden w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-base font-semibold text-gray-900 dark:text-white">Notifikasi</span>
                                <button id="mark-all-read" class="text-sm text-blue-600 p-1.5 hover:bg-blue-100 dark:hover:bg-gray-700 rounded">Tandai semua dibaca</button>
                            </div>
                        </div>
                        <div id="notification-list" class="max-h-64 overflow-y-auto">
                            <!-- Placeholder for notifications -->
                            <div class="py-4 px-3 text-center text-gray-500 dark:text-gray-400">Loading...</div>
                        </div>
                    </div>
                </div>

                <!-- Front Page -->
                <button class="w-full text-left px-4 py-2 text-sm cursor-pointer text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 group border-b border-gray-400">
                    <a href="{{ url('/') }}" class="">
                        <div class="flex items-center gap-2">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Front Page
                        </div>
                    </a>
                </button>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="post" class="border-b border-red-900">
                    @csrf
                    <button class="w-full text-left px-4 py-2 text-sm cursor-pointer text-red-700 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <div class="flex items-center">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </div>
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto bg-gradient-to-b from-blue-950 to-gray-950 p-6">
            @if (session('status'))
                <div class="mb-6">
                    <div id="alert-success" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div class="ml-3 text-sm font-medium">
                            {{ session('status') }}
                        </div>
                        <button type="button" class="ml-auto alert-close -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6">
                    <div id="alert-error" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.5 11.5-3.5-3.5L6.5 12l-1-1L9 7.5l-3.5-3.5 1-1L10 6.5 13.5 3l1 1L11 7.5l3.5 3.5-1 1Z" />
                        </svg>
                        <span class="sr-only">Error</span>
                        <div class="ml-3 text-sm font-medium">
                            {{ session('error') }}
                        </div>
                        <button type="button" class="ml-auto alert-close -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Content Loader -->
            <div id="content-wrapper">
                <div id="loading-spinner" class="flex justify-center items-center h-64">
                    <svg class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
                <div id="main-content" class="bg-gray-900/20 backdrop-blur-2xl rounded-lg shadow hidden">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Render modal content outside the main layout -->
@yield('modals')

<!-- Custom scripts -->
@yield('scripts')

<!-- JavaScript for Interactivity -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Notification Toggle
        const notificationToggle = document.getElementById('notification-toggle');
        const notificationDropdown = document.getElementById('notification-dropdown');
        const unreadIndicator = document.getElementById('unread-indicator');
        const notificationList = document.getElementById('notification-list');
        const markAllReadBtn = document.getElementById('mark-all-read');

        // Simulated notification data (replace with real API call if needed)
        let notifications = [
            { id: 1, message: 'New order received', read: false, time: '5 minutes ago' },
            { id: 2, message: 'Payment successfully confirmed', read: false, time: '1 hour ago' },
            { id: 3, message: 'System update available', read: true, time: 'Yesterday' }
        ];

        // Function to render notifications
        function renderNotifications() {
            notificationList.innerHTML = '';
            if (notifications.length === 0) {
                notificationList.innerHTML = '<div class="py-4 px-3 text-center text-gray-500 dark:text-gray-400">Tidak ada notifikasi</div>';
            } else {
                notifications.forEach(n => {
                    const div = document.createElement('div');
                    div.className = `flex p-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 ${!n.read ? 'bg-blue-50 dark:bg-blue-900/10' : ''}`;
                    div.innerHTML = `
                        <div class="ml-3 text-sm">
                            <div class="text-gray-800 dark:text-gray-300 font-medium">${n.message}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">${n.time}</div>
                        </div>
                    `;
                    div.addEventListener('click', () => markAsRead(n.id));
                    notificationList.appendChild(div);
                });
            }
            updateUnreadIndicator();
        }

        // Function to mark a notification as read
        function markAsRead(id) {
            notifications = notifications.map(n => n.id === id ? { ...n, read: true } : n);
            renderNotifications();
        }

        // Function to mark all notifications as read
        function markAllAsRead() {
            notifications = notifications.map(n => ({ ...n, read: true }));
            renderNotifications();
        }

        // Function to update unread indicator
        function updateUnreadIndicator() {
            const hasUnread = notifications.some(n => !n.read);
            unreadIndicator.classList.toggle('hidden', !hasUnread);
        }

        // Toggle notification dropdown
        notificationToggle.addEventListener('click', () => {
            notificationDropdown.classList.toggle('hidden');
            notificationDropdown.classList.toggle('invisible');
            notificationDropdown.classList.toggle('opacity-0');
        });

        // Mark all as read
        markAllReadBtn.addEventListener('click', markAllAsRead);

        // Simulate loading notifications
        setTimeout(() => {
            renderNotifications();
        }, 1000);

        // Content Loading
        const loadingSpinner = document.getElementById('loading-spinner');
        const mainContent = document.getElementById('main-content');

        // Simulate content loading
        setTimeout(() => {
            loadingSpinner.classList.add('hidden');
            mainContent.classList.remove('hidden');
            mainContent.classList.add('transition', 'ease-out', 'duration-300', 'opacity-100');
        }, 500);

        // Close alerts
        document.querySelectorAll('.alert-close').forEach(button => {
            button.addEventListener('click', () => {
                button.closest('.mb-6').classList.add('hidden');
            });
        });

        // Close notification dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!notificationToggle.contains(e.target) && !notificationDropdown.contains(e.target)) {
                notificationDropdown.classList.add('hidden', 'invisible', 'opacity-0');
            }
        });
    });
</script>

<!-- Flowbite JS (Optional, only if you need Flowbite features) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
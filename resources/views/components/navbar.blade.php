<!-- resources/views/components/navbar.blade.php -->
<nav class="bg-gray-900 fixed w-full z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between py-4">
            @php
                use App\Models\Setting;
                $currentRoute = Route::currentRouteName();
            @endphp
            <!-- Logo Section -->
            <div class="flex-shrink-0 flex items-center group">
                <a href="/"
                    class="text-white font-bold flex items-center space-x-3 transition duration-300 transform hover:scale-105">
                    <div class="relative overflow-hidden rounded-full bg-gradient-to-r from-orange-500 to-orange-400 p-0.5">
                        <img src="{{ asset('storage/' . Setting::get('site_logo')) }}" alt="Logo"
                            class="h-10 w-10 object-contain bg-gray-900 rounded-full p-1">
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-orange-400 to-orange-500 bg-clip-text text-transparent">
                        {{ Setting::get('site_name', 'Jasa Amanah') }}
                    </span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 sm:space-x-4">
                <a href="{{ route('home') }}"
                    class="border-b-2 {{ $currentRoute == 'home' ? 'border-orange-500 text-orange-400' : 'border-transparent text-gray-200 hover:border-orange-500 hover:text-orange-400' }} px-4 py-2 text-sm font-semibold transition duration-200 hover:bg-gray-800/50 rounded-t-md">
                    Home
                </a>
                
                <!-- Services Megamenu -->
                <div class="relative group">
                    <a href="{{ route('services') }}"
                        class="border-b-2 {{ $currentRoute == 'services' ? 'border-orange-500 text-orange-400' : 'border-transparent text-gray-200 hover:border-orange-500 hover:text-orange-400' }} px-4 py-2 text-sm font-semibold transition duration-200 hover:bg-gray-800/50 rounded-t-md flex items-center">
                        Services
                        <svg class="w-4 h-4 ml-1 text-gray-400 group-hover:text-orange-400 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <!-- Megamenu Dropdown -->
                    <div class="absolute -left-56 mt-2 w-[600px] bg-gray-800/95 backdrop-blur-sm border border-gray-700/50 rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:-translate-y-1 z-50">
                        <div class="grid grid-cols-2 gap-6 p-6">
                            @php
                                $categories = App\Models\Category::all();
                            @endphp
                            @forelse($categories as $category)
                                <div class="space-y-3">
                                    <a href="{{ route('services', ['category' => $category->id]) }}"
                                        class="block text-white font-semibold text-base hover:text-orange-400 transition duration-150 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        {{ $category->name }}
                                    </a>
                                    <p class="text-sm text-gray-400 line-clamp-2 leading-relaxed">
                                        {{ $category->description ?? 'Description of service.' }}
                                    </p>
                                </div>
                            @empty
                                <div class="col-span-2 text-gray-400 text-center py-4">
                                    There isn't any service available.
                                </div>
                            @endforelse
                        </div>
                        <div class="bg-gray-700/50 px-6 py-3 border-t border-gray-600/50 rounded-b-xl">
                            <a href="{{ route('services') }}"
                                class="text-orange-400 hover:text-orange-300 font-medium transition duration-150 flex items-center justify-center">
                                See All Services    
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('about') }}"
                    class="border-b-2 {{ $currentRoute == 'about' ? 'border-orange-500 text-orange-400' : 'border-transparent text-gray-200 hover:border-orange-500 hover:text-orange-400' }} px-4 py-2 text-sm font-semibold transition duration-200 hover:bg-gray-800/50 rounded-t-md">
                    About Us
                </a>
            </div>

            <!-- User Profile / Login -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                @guest
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}"
                            class="text-gray-200 bg-gray-800/50 hover:bg-gradient-to-r hover:from-orange-500 hover:to-orange-400 hover:text-white px-4 py-2 rounded-lg text-sm font-semibold transition duration-300 transform hover:scale-105">
                            Track Order
                        </a>
                    @endif
                @else
                    <div class="relative">
                        <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation"
                            class="text-white relative flex items-center space-x-3 group" type="button">
                            <div class="overflow-hidden rounded-full bg-gradient-to-r from-orange-500 to-orange-400 p-[2px] transition duration-300 transform group-hover:scale-105">
                                <img class="h-9 w-9 rounded-full object-cover"
                                    src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('storage/default-avatar.jpg') }}"
                                    alt="User profile">
                            </div>
                            <span class="text-sm font-semibold text-gray-200 group-hover:text-orange-400 transition duration-200">{{ Auth::user()->name }}</span>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdownInformation"
                            class="z-10 hidden bg-gray-800/95 backdrop-blur-sm divide-y divide-gray-700/50 rounded-xl shadow-2xl w-56 absolute right-0 mt-2 border border-gray-700/50">
                            <div class="px-4 py-3 text-sm text-white">
                                <div class="font-semibold text-orange-400">{{ Auth::user()->name }}</div>
                                <div class="font-medium truncate text-gray-300">{{ Auth::user()->email }}</div>
                            </div>
                            <ul class="py-2 text-sm text-gray-200">
                                <li>
                                    <a href="{{ Auth::user()->role === 'worker' ? route('worker.dashboard') : route('dashboard') }}"
                                        class="block px-4 py-2 hover:bg-gray-700/50 hover:text-orange-400 transition duration-150 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>Dashboard
                                    </a>
                                </li>
                                @if (Auth::user()->role === 'admin')
                                    <li>
                                        <a href="{{ route('admin.orders.index') }}"
                                            class="block px-4 py-2 hover:bg-gray-700/50 hover:text-orange-400 transition duration-150 flex items-center">
                                            <svg class="h-4 w-4 mr-2 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                            Orders
                                        </a>
                                    </li>
                                @elseif (Auth::user()->role === 'worker')
                                    <li>
                                        <a href="{{ route('worker.orders.index') }}"
                                            class="block px-4 py-2 hover:bg-gray-700/50 hover:text-orange-400 transition duration-150 flex items-center">
                                            <svg class="h-4 w-4 mr-2 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                            Orders
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ Auth::user()->role === 'admin' ? route('settings.index') : (Auth::user()->role === 'worker' ? route('worker.settings.index') : '/user/settings') }}"
                                        class="block px-4 py-2 hover:bg-gray-700/50 hover:text-orange-400 transition duration-150 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>Settings
                                    </a>
                                </li>
                            </ul>
                            <div class="py-1">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="cursor-pointer w-full">
                                    @csrf
                                    <button
                                        class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-700/50 hover:text-red-300 transition duration-150 flex items-center rounded-b-xl"
                                        type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        {{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button type="button" id="mobile-menu-button"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-orange-400 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-orange-500 transition duration-200"
                    aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="sm:hidden hidden" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1 px-2">
            <a href="{{ route('home') }}"
                class="{{ $currentRoute == 'home' ? 'bg-gradient-to-r from-orange-500 to-orange-400 text-white' : 'text-gray-200 hover:bg-gray-800 hover:text-orange-400' }} block px-4 py-2 rounded-md text-base font-semibold transition duration-150">
                Home
            </a>
            <!-- Mobile Services Menu -->
            <div class="space-y-1">
                <button type="button" id="mobile-services-toggle"
                    class="w-full text-left px-4 py-2 rounded-md text-base font-semibold text-gray-200 hover:bg-gray-800 hover:text-orange-400 transition duration-150 flex items-center justify-between">
                    Services
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="mobile-services-menu" class="hidden pl-4 space-y-1">
                    @forelse($categories as $category)
                        <a href="{{ route('services', ['category' => $category->id]) }}"
                            class="block px-4 py-2 rounded-md text-sm font-medium text-gray-200 hover:bg-gray-800 hover:text-orange-400 transition duration-150">
                            {{ $category->name }}
                        </a>
                    @empty
                        <div class="text-gray-400 px-4 py-2 text-sm">
                            Tidak ada kategori tersedia.
                        </div>
                    @endforelse
                    <a href="{{ route('services') }}"
                        class="block px-4 py-2 rounded-md text-sm font-medium text-orange-400 hover:bg-gray-800 hover:text-orange-300 transition duration-150">
                        Lihat Semua Layanan
                    </a>
                </div>
            </div>
            <a href="{{ route('about') }}"
                class="{{ $currentRoute == 'about' ? 'bg-gradient-to-r from-orange-500 to-orange-400 text-white' : 'text-gray-200 hover:bg-gray-800 hover:text-orange-400' }} block px-4 py-2 rounded-md text-base font-semibold transition duration-150">
                About Us
            </a>
        </div>

        @guest
            <div class="pt-4 pb-3 border-t border-gray-700 px-5">
                <a href="{{ route('login') }}"
                    class="bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 text-white block px-4 py-2 rounded-md text-base font-semibold text-center transition duration-150">
                    Login
                </a>
            </div>
        @else
            <div class="pt-4 pb-3 border-t border-gray-700">
                <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full object-cover"
                            src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('default-avatar.png') }}"
                            alt="User profile">
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-semibold text-white">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-400">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <a href="{{ Auth::user()->role === 'worker' ? route('worker.dashboard') : route('dashboard') }}"
                        class="block px-4 py-2 rounded-md text-base font-medium text-gray-200 hover:text-orange-400 hover:bg-gray-800 transition duration-150 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.orders.index') }}"
                            class="block px-4 py-2 rounded-md text-base font-medium text-gray-200 hover:text-orange-400 hover:bg-gray-800 transition duration-150 flex items-center">
                            <svg class="h-4 w-4 mr-2 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Orders
                        </a>
                    @elseif (Auth::user()->role === 'worker')
                        <a href="{{ route('worker.orders.index') }}"
                            class="block px-4 py-2 rounded-md text-base font-medium text-gray-200 hover:text-orange-400 hover:bg-gray-800 transition duration-150 flex items-center">
                            <svg class="h-4 w-4 mr-2 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Orders
                        </a>
                    @endif
                    <a href="{{ Auth::user()->role === 'admin' ? route('settings.index') : (Auth::user()->role === 'worker' ? route('worker.settings.index') : '/user/settings') }}"
                        class="block px-4 py-2 rounded-md text-base font-medium text-gray-200 hover:text-orange-400 hover:bg-gray-800 transition duration-150 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Settings
                    </a>
                    <div class="py-1">
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="cursor-pointer w-full">
                            @csrf
                            <button
                                class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-800 hover:text-red-300 transition duration-150 flex items-center rounded-b-md"
                                type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endguest
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileServicesToggle = document.getElementById('mobile-services-toggle');
        const mobileServicesMenu = document.getElementById('mobile-services-menu');

        // Toggle Mobile Menu
        mobileMenuButton.addEventListener('click', function() {
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'true');
                mobileMenu.style.maxHeight = '0';
                mobileMenu.style.overflow = 'hidden';
                mobileMenu.style.transition = 'max-height 0.3s ease-in-out';
                mobileMenu.offsetHeight;
                mobileMenu.style.maxHeight = '1000px'; // Increased for more content
            } else {
                mobileMenu.style.maxHeight = '0';
                setTimeout(function() {
                    mobileMenu.classList.add('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', 'false');
                }, 300);
            }
        });

        // Toggle Mobile Services Menu
        mobileServicesToggle.addEventListener('click', function() {
            mobileServicesMenu.classList.toggle('hidden');
            mobileServicesMenu.style.transition = 'max-height 0.3s ease-in-out';
            if (!mobileServicesMenu.classList.contains('hidden')) {
                mobileServicesMenu.style.maxHeight = mobileServicesMenu.scrollHeight + 'px';
            } else {
                mobileServicesMenu.style.maxHeight = '0';
            }
        });

        // User Dropdown
        const dropdownButton = document.getElementById('dropdownInformationButton');
        const dropdown = document.getElementById('dropdownInformation');

        if (dropdownButton) {
            dropdownButton.addEventListener('click', function() {
                dropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', function(event) {
                if (!dropdownButton.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        }

        // Close mobile menu on resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 640) {
                mobileMenu.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                mobileMenu.style.maxHeight = null;
                mobileServicesMenu.classList.add('hidden');
                mobileServicesMenu.style.maxHeight = null;
            }
        });
    });
</script>
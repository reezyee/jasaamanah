@extends('layouts.app')

@section('content')
<div class="pt-24 pb-12 md:pt-32 md:pb-20 relative overflow-hidden bg-gradient-to-b from-gray-900 to-gray-800">
    <!-- Background Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute w-96 h-96 bg-orange-400/10 rounded-full -top-48 -left-48 blur-3xl animate-pulse"></div>
        <div class="absolute w-72 h-72 bg-blue-400/10 rounded-full bottom-0 right-0 blur-3xl animate-pulse delay-1000"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight">
                <span class="bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">Our Services</span>
            </h1>
            <p class="mt-3 text-gray-400 text-lg max-w-2xl mx-auto">
                Find the best service that is fast and reliable for you.
            </p>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-gray-800/80 backdrop-blur-md border border-gray-700/50 rounded-2xl shadow-2xl mb-12 p-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-grow">
                    <input 
                        type="text" 
                        id="search" 
                        placeholder="Search services..." 
                        class="w-full pl-12 pr-4 py-3 bg-gray-700/50 text-white border-2 border-gray-600/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-400/50 focus:border-transparent placeholder-gray-400 transition-all duration-300"
                    >
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <div class="relative flex-shrink-0 md:w-64">
                    <select 
                        id="category" 
                        class="appearance-none w-full pl-4 pr-10 py-3 bg-gray-700/50 text-white border-2 border-gray-600/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-400/50 focus:border-transparent transition-all duration-300"
                    >
                        <option value="" class="bg-gray-800">All Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" class="bg-gray-800">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Service List -->
        <div id="service-list" class="relative">
            @include('pages.partials.service-list', ['services' => $services])
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center" id="pagination">
            {{ $services->links() }}
        </div>
    </div>
</div>

<script>
    document.getElementById('search').addEventListener('input', debounce(fetchServices, 300));
    document.getElementById('category').addEventListener('change', fetchServices);

    function fetchServices() {
        const search = document.getElementById('search').value;
        const category = document.getElementById('category').value;
        const serviceList = document.getElementById('service-list');
        
        // Loading animation
        serviceList.innerHTML = `
            <div class="absolute inset-0 flex items-center justify-center bg-gray-800/50 backdrop-blur-sm rounded-xl">
                <div class="w-12 h-12 border-4 border-orange-400 border-t-transparent rounded-full animate-spin"></div>
            </div>
        `;

        fetch(`{{ route('services') }}?search=${encodeURIComponent(search)}&category=${encodeURIComponent(category)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            serviceList.innerHTML = data.html;
            document.getElementById('pagination').innerHTML = data.pagination;
        })
        .catch(error => {
            console.error('Error fetching services:', error);
            serviceList.innerHTML = '<div class="text-center text-red-400 p-6">Something went wrong.</div>';
        });
    }

    // Debounce function to limit frequent calls
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
</script>
@endsection
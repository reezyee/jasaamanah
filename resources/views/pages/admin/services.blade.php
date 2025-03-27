{{-- Services Blade with Dark Mode --}}
@extends('layouts.user')

<div class="fixed bottom-6 right-6 z-50">
    <!-- Add Service Button -->
    <button data-popover-target="popover-left" data-popover-placement="left" type="button"
        data-modal-target="serviceFormModal" data-modal-toggle="serviceFormModal" id="openModalButton"
        class="bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg transition-colors flex items-center group relative">
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-14 h-14 text-center p-2 group-hover:scale-110 transition-transform" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
    </button>

    <!-- Popover -->
    <div data-popover id="popover-left" role="tooltip"
        class="absolute z-10 visible opacity-100 inline-block w-fit text-sm font-bold text-nowrap border rounded-lg shadow-md text-gray-200 border-gray-600 bg-blue-800">
        <div class="px-3 py-2">
            <p>Add Service</p>
        </div>
        <div data-popper-arrow></div>
    </div>
</div>
<!-- Toast Notification Container -->
@section('content')
    <div class="container mx-auto pt-8 text-gray-200">
        <div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-2"></div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-800 text-green-200 px-4 py-3 rounded mb-4 shadow flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
                <button type="button" class="text-green-200 hover:text-white" onclick="this.parentElement.remove()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Filter Section -->
        <div class="mb-6 p-4 bg-gray-900 rounded-lg shadow">
            <form id="filterForm" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block mb-2 text-sm font-medium text-white">Search</label>
                    <input type="text" id="search" name="search"
                        class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Service name...">
                </div>

                <div>
                    <label for="filter_category" class="block mb-2 text-sm font-medium text-white">Category</label>
                    <select id="filter_category" name="category_id"
                        class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="price_min" class="block mb-2 text-sm font-medium text-white">Min Price</label>
                    <input type="number" id="price_min" name="price_min"
                        class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="0">
                </div>

                <div>
                    <label for="price_max" class="block mb-2 text-sm font-medium text-white">Max Price</label>
                    <input type="number" id="price_max" name="price_max"
                        class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="100000">
                </div>

                <div class="md:col-span-4 flex items-center justify-end gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow transition-colors">
                        Apply Filters
                    </button>
                    <button type="reset"
                        class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded shadow transition-colors">
                        Clear Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Bulk Actions -->
        <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <button id="bulkDeleteBtn" disabled
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded shadow transition-colors flex items-center opacity-50 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Selected
                </button>
            </div>
            <div class="text-sm text-gray-400">
                <span id="selectedCount">0</span> services selected
            </div>
        </div>
    </div>

    <!-- Service Table -->
    <div class="overflow-x-auto rounded-lg shadow bg-gray-900">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-800 text-gray-300">
                    <th class="py-3 px-4 text-left">
                        <input type="checkbox" id="selectAll"
                            class="rounded bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500">
                    </th>
                    <th class="py-3 px-4 text-left">Name</th>
                    <th class="py-3 px-4 text-left">Category</th>
                    <th class="py-3 px-4 text-left">Price</th>
                    <th class="py-3 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr class="border-b border-gray-700 hover:bg-gray-800 transition-colors text-gray-300"
                        data-id="{{ $service->id }}">
                        <td class="py-3 px-4">
                            <input type="checkbox"
                                class="service-checkbox rounded bg-gray-700 border-gray-600 text-blue-600 focus:ring-blue-500"
                                value="{{ $service->id }}">
                        </td>
                        <td class="py-3 px-4">{{ $service->name }}</td>
                        <td class="py-3 px-4">{{ $service->category->name }}</td>
                        <td class="py-3 px-4">Rp{{ number_format($service->price, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 flex gap-2">
                            <button data-modal-target="serviceFormModal" data-modal-toggle="serviceFormModal"
                                onclick="editService({{ $service->id }})"
                                class="px-3 py-1 bg-amber-600 hover:bg-amber-700 text-white rounded text-sm transition-colors flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </button>
                            <button onclick="prepareDeleteService({{ $service->id }}, '{{ $service->name }}')"
                                class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm transition-colors flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if ($services->hasPages())
        <div class="mt-6 px-4 flex justify-center">
            {{ $services->links('pagination::tailwind') }}
        </div>
    @else
        <div class="mt-6 px-4 text-gray-400">
            No additional pages available.
        </div>
    @endif
    </div>
@endsection

@section('modals')
    <!-- Service Form Modal -->
    <div id="serviceFormModal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full h-full overflow-x-hidden overflow-y-auto flex items-center justify-center">
        <!-- Modal background overlay -->
        <div class="fixed inset-0 bg-gray-900/50 bg-opacity-75 transition-opacity"></div>

        <!-- Modal content -->
        <div class="relative bg-gray-800 rounded-lg shadow max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0"
            id="serviceFormContent">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t border-gray-700">
                <h3 id="formTitle" class="text-xl font-medium text-white">
                    Add Service
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                    data-modal-hide="serviceFormModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <form id="serviceForm">
                    @csrf
                    <input type="hidden" id="serviceId" name="serviceId" value="">
                    <input type="hidden" id="_method" name="_method" value="POST">

                    <div class="mb-6">
                        <label for="serviceName" class="block mb-2 text-sm font-medium text-white">Service Name</label>
                        <input type="text" id="serviceName" name="name" autofocus
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                    </div>

                    <div class="mb-6">
                        <label for="categoryId" class="block mb-2 text-sm font-medium text-white">Category</label>
                        <select id="categoryId" name="category_id"
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="servicePrice" class="block mb-2 text-sm font-medium text-white">Price</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="text-gray-400">Rp</span>
                            </div>
                            <input type="number" id="servicePrice" name="price"
                                class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                                required min="0">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex items-center space-x-2 border-t border-gray-700 rounded-b pt-4">
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Save
                        </button>
                        <button type="button"
                            class="text-gray-300 bg-gray-700 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-600 rounded-lg border border-gray-600 text-sm font-medium px-5 py-2.5 hover:text-white focus:z-10"
                            data-modal-hide="serviceFormModal">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmModal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full h-full overflow-x-hidden overflow-y-auto flex items-center justify-center">
        <!-- Modal background overlay -->
        <div class="fixed inset-0 bg-gray-900/50 bg-opacity-75 transition-opacity"></div>

        <!-- Modal content -->
        <div class="relative bg-gray-800 rounded-lg shadow max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0"
            id="deleteModalContent">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t border-gray-700">
                <h3 class="text-xl font-medium text-white">
                    Confirm Delete
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                    data-modal-hide="deleteConfirmModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6">
                <div class="flex items-center mb-4 text-red-500">
                    <svg class="w-10 h-10 mr-4" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-lg font-medium text-white">Are you sure you want to delete this service?</p>
                </div>
                <p class="text-gray-300 mb-6">You are about to delete <span id="deleteServiceName"
                        class="font-medium text-white"></span>. This action cannot be undone.</p>

                <form id="deleteServiceForm" method="POST">
                    @csrf
                    @method('DELETE')

                    <!-- Modal footer -->
                    <div class="flex items-center justify-end space-x-2 border-t border-gray-700 rounded-b pt-4">
                        <button type="button"
                            class="text-gray-300 bg-gray-700 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-600 rounded-lg border border-gray-600 text-sm font-medium px-5 py-2.5 hover:text-white focus:z-10"
                            data-modal-hide="deleteConfirmModal">
                            Cancel
                        </button>
                        <button type="submit"
                            class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-900 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Delete Service
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bulk Delete Confirmation Modal -->
    <div id="bulkDeleteModal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full h-full overflow-x-hidden overflow-y-auto flex items-center justify-center">
        <!-- Modal background overlay -->
        <div class="fixed inset-0 bg-gray-900/50 bg-opacity-75 transition-opacity"></div>

        <!-- Modal content -->
        <div class="relative bg-gray-800 rounded-lg shadow max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0"
            id="bulkDeleteModalContent">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t border-gray-700">
                <h3 class="text-xl font-medium text-white">
                    Confirm Bulk Delete
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                    data-modal-hide="bulkDeleteModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6">
                <div class="flex items-center mb-4 text-red-500">
                    <svg class="w-10 h-10 mr-4" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-lg font-medium text-white">Are you sure you want to delete these services?</p>
                </div>
                <p class="text-gray-300 mb-6">You are about to delete <span id="bulkDeleteCount"
                        class="font-medium text-white"></span> services. This action cannot be undone.</p>

                <form id="bulkDeleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="bulkDeleteIds" name="ids" value="">

                    <!-- Modal footer -->
                    <div class="flex items-center justify-end space-x-2 border-t border-gray-700 rounded-b pt-4">
                        <button type="button"
                            class="text-gray-300 bg-gray-700 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-600 rounded-lg border border-gray-600 text-sm font-medium px-5 py-2.5 hover:text-white focus:z-10"
                            data-modal-hide="bulkDeleteModal">
                            Cancel
                        </button>
                        <button type="submit"
                            class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-900 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Delete Services
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set up the modal for adding a new service
            document.getElementById('openModalButton').addEventListener('click', function() {
                prepareAddService();
            });

            // Handle modal show/hide animations
            const modals = document.querySelectorAll('[data-modal-target]');
            const modalHideButtons = document.querySelectorAll('[data-modal-hide]');
            const serviceNameInput = document.getElementById("serviceName");

            modals.forEach(button => {
                button.addEventListener('click', () => {
                    const targetModal = document.getElementById(button.getAttribute(
                        'data-modal-target'));
                    const modalContent = targetModal.querySelector('.relative');

                    targetModal.classList.remove('hidden');
                    setTimeout(() => {
                        modalContent.classList.remove('scale-95', 'opacity-0');
                        modalContent.classList.add('scale-100', 'opacity-100');
                        serviceNameInput.focus();
                    }, 50);
                });
            });

            modalHideButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const targetModal = document.getElementById(button.getAttribute(
                        'data-modal-hide'));
                    const modalContent = targetModal.querySelector('.relative');

                    modalContent.classList.remove('scale-100', 'opacity-100');
                    modalContent.classList.add('scale-95', 'opacity-0');

                    setTimeout(() => {
                        targetModal.classList.add('hidden');
                    }, 300);
                });
            });

            // Form submission handling
            document.getElementById('serviceForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const serviceId = document.getElementById('serviceId').value;
                const method = serviceId ? 'PUT' : 'POST';
                const url = serviceId ? `/admin/services/${serviceId}` : '/admin/services';

                const formData = new FormData(this);

                fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            name: formData.get('name'),
                            category_id: formData.get('category_id'),
                            price: formData.get('price')
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Hide modal
                        const targetModal = document.getElementById('serviceFormModal');
                        const modalContent = targetModal.querySelector('.relative');

                        modalContent.classList.remove('scale-100', 'opacity-100');
                        modalContent.classList.add('scale-95', 'opacity-0');

                        setTimeout(() => {
                            targetModal.classList.add('hidden');

                            // Show toast notification
                            showToast(
                                serviceId ? 'Service updated successfully!' :
                                'Service created successfully!',
                                'success'
                            );

                            location.reload(); // Reload to see changes
                        }, 300);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('An error occurred. Please try again.', 'error');
                    });
            });

            // Delete form submission
            document.getElementById('deleteServiceForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const url = this.getAttribute('action');

                fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Hide modal
                        const targetModal = document.getElementById('deleteConfirmModal');
                        const modalContent = targetModal.querySelector('.relative');

                        modalContent.classList.remove('scale-100', 'opacity-100');
                        modalContent.classList.add('scale-95', 'opacity-0');

                        setTimeout(() => {
                            targetModal.classList.add('hidden');

                            // Show toast notification
                            showToast('Service deleted successfully!', 'success');

                            location.reload(); // Reload to see changes
                        }, 300);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('An error occurred while deleting. Please try again.', 'error');
                    });
            });
        });

        // Initialize filter form
        const filterForm = document.getElementById('filterForm');

        if (filterForm) {
            filterForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Get form data
                const formData = new FormData(this);
                const params = new URLSearchParams();

                // Add only non-empty values to URL parameters
                for (const [key, value] of formData.entries()) {
                    if (value.trim() !== '') {
                        params.append(key, value);
                    }
                }

                // Redirect with filter parameters
                window.location.href = window.location.pathname + '?' + params.toString();
            });

            // Handle reset button
            filterForm.querySelector('button[type="reset"]').addEventListener('click', function() {
                window.location.href = window.location.pathname;
            });

            // Pre-fill form with URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            for (const [key, value] of urlParams.entries()) {
                const input = filterForm.querySelector(`[name="${key}"]`);
                if (input) {
                    input.value = value;
                }
            }
        }

        // Initialize bulk delete feature
        const selectAll = document.getElementById('selectAll');
        const serviceCheckboxes = document.querySelectorAll('.service-checkbox');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const selectedCount = document.getElementById('selectedCount');

        // Handle select all checkbox
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const isChecked = this.checked;

                serviceCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });

                updateBulkDeleteButton();
            });
        }

        // Handle individual checkboxes
        serviceCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateBulkDeleteButton();

                // Update select all checkbox
                if (!this.checked) {
                    selectAll.checked = false;
                } else {
                    const allChecked = Array.from(serviceCheckboxes).every(cb => cb.checked);
                    selectAll.checked = allChecked;
                }
            });
        });

        // Update bulk delete button state
        function updateBulkDeleteButton() {
            const checkedServices = document.querySelectorAll('.service-checkbox:checked');
            const count = checkedServices.length;

            // Update selected count display
            selectedCount.textContent = count;

            if (count > 0) {
                bulkDeleteBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                bulkDeleteBtn.disabled = false;
            } else {
                bulkDeleteBtn.classList.add('opacity-50', 'cursor-not-allowed');
                bulkDeleteBtn.disabled = true;
            }
        }

        // Handle bulk delete button click
        if (bulkDeleteBtn) {
            bulkDeleteBtn.addEventListener('click', function() {
                const selectedIds = Array.from(document.querySelectorAll('.service-checkbox:checked'))
                    .map(checkbox => checkbox.value);

                if (selectedIds.length === 0) return;

                // Update bulk delete modal
                document.getElementById('bulkDeleteCount').textContent = selectedIds.length;
                // Don't JSON.stringify the IDs here
                document.getElementById('bulkDeleteIds').value = selectedIds.join(',');

                // Show bulk delete modal
                const bulkDeleteModal = document.getElementById('bulkDeleteModal');
                const bulkDeleteModalContent = document.getElementById('bulkDeleteModalContent');

                bulkDeleteModal.classList.remove('hidden');
                setTimeout(() => {
                    bulkDeleteModalContent.classList.remove('scale-95', 'opacity-0');
                    bulkDeleteModalContent.classList.add('scale-100', 'opacity-100');
                }, 50);
            });
        }

        // Handle bulk delete form submission
        const bulkDeleteForm = document.getElementById('bulkDeleteForm');
        if (bulkDeleteForm) {
            bulkDeleteForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Get the selected IDs from checkboxes
                const selectedIds = Array.from(document.querySelectorAll('.service-checkbox:checked'))
                    .map(checkbox => checkbox.value);

                fetch('/admin/services/bulk-delete', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            ids: selectedIds // Send as array, not as string
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.message || 'Server error');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Hide modal
                        const targetModal = document.getElementById('bulkDeleteModal');
                        const modalContent = targetModal.querySelector('.relative');

                        modalContent.classList.remove('scale-100', 'opacity-100');
                        modalContent.classList.add('scale-95', 'opacity-0');

                        setTimeout(() => {
                            targetModal.classList.add('hidden');
                            showToast('Services deleted successfully!', 'success');
                            location.reload(); // Reload to see changes
                        }, 300);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('An error occurred while deleting services. Please try again.', 'error');
                    });
            });
        }
        // Function to prepare Add Service form
        function prepareAddService() {
            document.getElementById('formTitle').innerText = 'Add Service';
            document.getElementById('serviceId').value = '';
            document.getElementById('_method').value = 'POST';

            document.getElementById('serviceName').value = '';
            document.getElementById('categoryId').value = document.getElementById('categoryId').options[0].value;
            document.getElementById('servicePrice').value = '';
        }

        // Function to prepare Edit Service form
        function editService(id) {
            // Show loading toast
            showToast('Loading service data...', 'info', 2000);

            fetch(`/admin/services/${id}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch service data');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('formTitle').innerText = 'Edit Service';
                    document.getElementById('serviceId').value = data.id;
                    document.getElementById('_method').value = 'PUT';

                    document.getElementById('serviceName').value = data.name;
                    document.getElementById('categoryId').value = data.category_id;
                    document.getElementById('servicePrice').value = data.price;

                    // Show the modal
                    const serviceModal = document.getElementById('serviceFormModal');
                    const modalContent = serviceModal.querySelector('.relative');
                    serviceModal.classList.remove('hidden');
                    setTimeout(() => {
                        modalContent.classList.remove('scale-95', 'opacity-0');
                        modalContent.classList.add('scale-100', 'opacity-100');
                    }, 50);

                    showToast('Service data loaded successfully', 'success', 2000);
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Failed to load service data', 'error');
                });
        }

        // Function to prepare Delete Service modal
        function prepareDeleteService(id, name) {
            document.getElementById('deleteServiceName').textContent = name;
            document.getElementById('deleteServiceForm').setAttribute('action', `/admin/services/${id}`);

            // Show delete confirmation modal
            const deleteModal = document.getElementById('deleteConfirmModal');
            const deleteModalContent = document.getElementById('deleteModalContent');

            deleteModal.classList.remove('hidden');
            setTimeout(() => {
                deleteModalContent.classList.remove('scale-95', 'opacity-0');
                deleteModalContent.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        // Function to show toast notifications
        function showToast(message, type = 'info', duration = 5000) {
            const toastContainer = document.getElementById('toast-container');

            // Create toast element
            const toast = document.createElement('div');
            toast.classList.add(
                'flex', 'items-center', 'p-4', 'mb-4', 'rounded-lg', 'shadow', 'max-w-xs',
                'transform', 'transition-all', 'duration-300', 'translate-y-2', 'opacity-0'
            );

            // Set background and icon based on toast type
            let iconSvg = '';
            switch (type) {
                case 'success':
                    toast.classList.add('bg-green-800', 'text-green-200');
                    iconSvg = `<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>`;
                    break;
                case 'error':
                    toast.classList.add('bg-red-800', 'text-red-200');
                    iconSvg = `<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>`;
                    break;
                case 'info':
                default:
                    toast.classList.add('bg-blue-800', 'text-blue-200');
                    iconSvg = `<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v4a1 1 0 102 0V7zm-1-5a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                    </svg>`;
            }

            // Build toast content
            toast.innerHTML = `
                <div class="flex items-center">
                    ${iconSvg}
                    <div>${message}</div>
                </div>
                <button type="button" class="ml-auto text-gray-300 hover:text-white" onclick="this.parentElement.remove()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;

            // Add to container
            toastContainer.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-y-2', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            }, 10);

            // Auto remove after duration
            setTimeout(() => {
                toast.classList.add('translate-y-2', 'opacity-0');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, duration);
        }
    </script>
@endsection

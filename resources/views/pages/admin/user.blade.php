{{-- User Blade --}}
@extends('layouts.user')
<div class="fixed bottom-6 right-6 z-50">
    <!-- Tombol Add User -->
    <button data-popover-target="popover-left" data-popover-placement="left" type="button"
        data-modal-target="userFormModal" data-modal-toggle="userFormModal" id="openModalButton"
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
            <p>Add User</p>
        </div>
        <div data-popper-arrow></div>
    </div>
</div>
@section('content')
    <div class="mx-auto pt-8 text-gray-200">
        <div class="px-4">
            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-800 text-green-200 px-4 py-3 rounded mb-4 shadow flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
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
        </div>

        <!-- Filter Section -->
        <div class="px-4 mb-4">
            <div class="bg-gray-900 p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold text-gray-200 mb-3">Filter Users</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="nameFilter" class="block text-sm font-medium text-gray-300 mb-1">Name</label>
                        <input type="text" id="nameFilter"
                            class="w-full rounded px-3 py-2 text-gray-300 bg-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="emailFilter" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                        <input type="text" id="emailFilter"
                            class="w-full rounded px-3 py-2 text-gray-300 bg-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="roleFilter" class="block text-sm font-medium text-gray-300 mb-1">Role</label>
                        <select id="roleFilter"
                            class="w-full rounded px-3 py-2 text-gray-300 bg-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Roles</option>
                            <option value="admin">Admin</option>
                            <option value="worker">Worker</option>
                            <option value="client">Client</option>
                        </select>
                    </div>
                    <div>
                        <label for="divisionFilter" class="block text-sm font-medium text-gray-300 mb-1">Division</label>
                        <input type="text" id="divisionFilter"
                            class="w-full rounded px-3 py-2 text-gray-300 bg-gray-800 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- User Table -->
        <div class="overflow-x-auto rounded-lg shadow bg-gray-900">
            <div id="userTableContainer">
                @include('pages.admin.partials.user', ['filteredUsers' => $users])
            </div>
        </div>

        <!-- Pagination if needed -->
        <div class="mt-4 px-4">
            @if (method_exists($users, 'links'))
                {{ $users->links() }}
            @endif
        </div>
    </div>
@endsection

@section('modals')
    <!-- User Form Modal -->
    <div id="userFormModal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full h-full overflow-x-hidden overflow-y-auto flex items-center justify-center">
        <!-- Modal background overlay -->
        <div class="fixed inset-0 bg-gray-900/50 bg-opacity-75 transition-opacity"></div>

        <!-- Modal content -->
        <div class="relative bg-gray-800 rounded-lg shadow max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0"
            id="userFormContent">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t border-gray-700">
                <h3 id="formTitle" class="text-xl font-medium text-white">
                    Add User
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                    data-modal-hide="userFormModal">
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
                <form id="userFormAction" method="POST">
                    @csrf
                    <input type="hidden" id="_method" name="_method" value="POST">

                    <div class="mb-6">
                        <label for="name" class="block mb-2 text-sm font-medium text-white">Name</label>
                        <input type="text" id="name" name="name"
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                    </div>

                    <div class="mb-6">
                        <label for="email" class="block mb-2 text-sm font-medium text-white">Email</label>
                        <input type="email" id="email" name="email"
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                    </div>

                    <div class="mb-6" id="passwordField">
                        <label for="password" class="block mb-2 text-sm font-medium text-white">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password"
                                class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <button type="button" id="togglePassword"
                                class="absolute right-2 top-2.5 text-gray-400 hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="role" class="block mb-2 text-sm font-medium text-white">Role</label>
                        <select id="role" name="role"
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                            <option value="client">Client</option>
                            <option value="worker">Worker</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="mb-6 hidden" id="divisionField">
                        <label for="division" class="block mb-2 text-sm font-medium text-white">Division</label>
                        <select id="division" name="division"
                            class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Select Division</option>
                            <option value="Legality">Legality</option>
                            <option value="Design">Design</option>
                            <option value="Website">Website</option>
                        </select>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex items-center space-x-2 border-t border-gray-700 rounded-b pt-4">
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Save
                        </button>
                        <button type="button"
                            class="text-gray-300 bg-gray-700 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-600 rounded-lg border border-gray-600 text-sm font-medium px-5 py-2.5 hover:text-white focus:z-10"
                            data-modal-hide="userFormModal">
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
                    <p class="text-lg font-medium text-white">Are you sure you want to delete this user?</p>
                </div>
                <p class="text-gray-300 mb-6">You are about to delete <span id="deleteUserName"
                        class="font-medium text-white"></span>. This action cannot be undone.</p>

                <form id="deleteUserForm" method="POST">
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
                            Delete User
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
            // Set up the modal for adding a new user
            document.getElementById('openModalButton').addEventListener('click', function() {
                prepareAddUser();
            });

            // Handle modal show/hide animations
            const modals = document.querySelectorAll('[data-modal-target]');
            const modalHideButtons = document.querySelectorAll('[data-modal-hide]');

            modals.forEach(button => {
                button.addEventListener('click', () => {
                    const targetModal = document.getElementById(button.getAttribute(
                        'data-modal-target'));
                    const modalContent = targetModal.querySelector('.relative');

                    targetModal.classList.remove('hidden');
                    setTimeout(() => {
                        modalContent.classList.remove('scale-95', 'opacity-0');
                        modalContent.classList.add('scale-100', 'opacity-100');
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

            // Password visibility toggle
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle the eye icon
                this.innerHTML = type === 'password' ?
                    '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>' :
                    '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>';
            });

            // Role change event listener
            document.getElementById('role').addEventListener('change', function() {
                if (this.value === 'worker') {
                    document.getElementById('divisionField').classList.remove('hidden');
                } else {
                    document.getElementById('divisionField').classList.add('hidden');
                }
            });

            // Get all filter inputs
            const nameFilter = document.getElementById('nameFilter');
            const emailFilter = document.getElementById('emailFilter');
            const roleFilter = document.getElementById('roleFilter');
            const divisionFilter = document.getElementById('divisionFilter');

            // Add event listeners to inputs
            nameFilter.addEventListener('input', applyFilters);
            emailFilter.addEventListener('input', applyFilters);
            roleFilter.addEventListener('change', applyFilters);
            divisionFilter.addEventListener('input', applyFilters);

            // Function to prepare Add User form
            function prepareAddUser() {
                document.getElementById('formTitle').innerText = 'Add User';
                document.getElementById('userFormAction').setAttribute('action',
                '{{ route('admin.users.store') }}');
                document.getElementById('_method').value = 'POST';
                document.getElementById('passwordField').style.display = 'block';

                document.getElementById('name').value = '';
                document.getElementById('email').value = '';
                document.getElementById('password').value = '';
                document.getElementById('role').value = 'client';
                document.getElementById('division').value = '';
                document.getElementById('divisionField').classList.add('hidden');
            }
        });

        // Debounce function to limit API calls
        let debounceTimer;

        function debounce(callback, time = 300) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(callback, time);
        }

        // Apply filters function
        function applyFilters() {
            debounce(() => {
                const nameFilter = document.getElementById('nameFilter');
                const emailFilter = document.getElementById('emailFilter');
                const roleFilter = document.getElementById('roleFilter');
                const divisionFilter = document.getElementById('divisionFilter');

                const filters = {
                    name: nameFilter.value,
                    email: emailFilter.value,
                    role: roleFilter.value,
                    division: divisionFilter.value
                };

                // Show loading indicator
                const tableContainer = document.getElementById('userTableContainer');
                tableContainer.innerHTML =
                    '<div class="flex justify-center items-center p-8"><svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>';

                // Make Ajax request
                fetch('/admin/user?' + new URLSearchParams(filters), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        tableContainer.innerHTML = data.html;

                        // Re-initialize any event handlers for the new content
                        initializeEventHandlers();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        tableContainer.innerHTML =
                            '<div class="p-4 text-red-300">Error loading data. Please try again.</div>';
                    });
            });
        }

        // Function to re-initialize event handlers after content is updated
        function initializeEventHandlers() {
            // Reinitialize edit and delete buttons for the new content
            const editButtons = document.querySelectorAll('[data-edit-user]');
            const deleteButtons = document.querySelectorAll('[data-delete-user]');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userData = JSON.parse(this.getAttribute('data-edit-user'));
                    prepareEditUser(userData);
                });
            });

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    const userName = this.getAttribute('data-user-name');
                    prepareDeleteUser(userId, userName);
                });
            });
        }

        // Function to prepare Edit User form
        function prepareEditUser(user) {
            document.getElementById('formTitle').innerText = 'Edit User';
            document.getElementById('userFormAction').setAttribute('action', `/admin/user/${user.id}`);
            document.getElementById('_method').value = 'PUT';

            document.getElementById('passwordField').style.display = 'none'; // Hide password field when editing
            document.getElementById('name').value = user.name;
            document.getElementById('email').value = user.email;
            document.getElementById('role').value = user.role;

            // For division, we need to select the correct option
            const divisionSelect = document.getElementById('division');
            divisionSelect.value = user.division || '';

            if (user.role === 'worker') {
                document.getElementById('divisionField').classList.remove('hidden');
            } else {
                document.getElementById('divisionField').classList.add('hidden');
            }
        }

        // Function to prepare Delete User modal
        function prepareDeleteUser(userId, userName) {
            document.getElementById('deleteUserName').textContent = userName;
            document.getElementById('deleteUserForm').setAttribute('action', `/admin/user/${userId}`);

            // Show delete confirmation modal
            const deleteModal = document.getElementById('deleteConfirmModal');
            const deleteModalContent = document.getElementById('deleteModalContent');

            deleteModal.classList.remove('hidden');
            setTimeout(() => {
                deleteModalContent.classList.remove('scale-95', 'opacity-0');
                deleteModalContent.classList.add('scale-100', 'opacity-100');
            }, 50);
        }
    </script>
@endsection

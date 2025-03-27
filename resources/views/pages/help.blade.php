@extends('layouts.user')

@section('content')
    <div class=" text-gray-100 min-h-screen py-8 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="mb-8 text-center">
                <h1 class="text-4xl font-bold text-blue-400 mb-3">Help & Support</h1>
                <p class="text-gray-400">Find answers to common questions or reach out to our support team</p>
            </div>

            <!-- FAQ Section -->
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-blue-300 mb-6 border-b border-gray-700 pb-2">Frequently Asked Questions
                </h2>

                <div class="space-y-4">
                    <!-- FAQ Item 1 -->
                    <div class="collapse-item">
                        <div
                            class="collapse-header bg-gray-700 hover:bg-gray-600 cursor-pointer rounded-md p-4 flex justify-between items-center">
                            <h3 class="text-lg font-medium">How do I reset my password?</h3>
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                        <div class="collapse-content bg-gray-700 bg-opacity-50 p-4 rounded-b-md">
                            <p>Go to the settings page and click on "Reset Password" to change your password.</p>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="collapse-item">
                        <div
                            class="collapse-header bg-gray-700 hover:bg-gray-600 cursor-pointer rounded-md p-4 flex justify-between items-center">
                            <h3 class="text-lg font-medium">How can I contact support?</h3>
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                        <div class="collapse-content bg-gray-700 bg-opacity-50 p-4 rounded-b-md">
                            <p>You can reach us at <a href="mailto:support@jasaamanah.com"
                                    class="text-blue-300 hover:text-blue-200">support@jasaamanah.com</a>.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Guide Section -->
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-blue-300 mb-6 border-b border-gray-700 pb-2">User Guide</h2>

                @if (auth()->user()->role == 'admin')
                    <!-- Tabs Content -->
                    <div class="bg-gray-700 rounded-md p-6 max-h-96 overflow-y-auto">
                        <h3 class="text-lg font-semibold text-white mb-4">Admin User Guide</h3>
                        <p class="text-gray-300 mb-4">Welcome to the Admin Dashboard! As an Admin, you have full control
                            over managing tasks, orders, users, and services. Below is a step-by-step guide to help you
                            navigate and utilize the system effectively.</p>
                        <ul class="list-disc list-inside text-gray-300 space-y-2">
                            <li><strong>Manage Tasks:</strong> Go to the "Task Management" section to create, update, or
                                delete tasks. You can assign tasks to workers, set statuses, and attach files.</li>
                            <li><strong>Manage Orders:</strong> In the "Orders" section, you can view all client orders,
                                update their status, and assign them to workers.</li>
                            <li><strong>Manage Users:</strong> The "Users" section allows you to add, edit, or remove users
                                (clients and workers).</li>
                            <li><strong>Manage Services:</strong> Add or update available services in the "Services" section
                                to offer them to clients.</li>
                            <li><strong>Track Progress:</strong> Use the dashboard to monitor the progress of tasks and
                                orders in real-time.</li>
                            <li><strong>Settings:</strong> Update your profile, password, and website settings in the
                                "Settings" section.</li>
                        </ul>
                        <p class="text-gray-300 mt-4">If you encounter any issues, contact support at <a
                                href="mailto:support@example.com"
                                class="text-blue-400 hover:underline">support@example.com</a>.</p>
                    </div>
                @elseif (Auth::user()->role == 'worker')
                    <div class="bg-gray-700 rounded-md p-6 max-h-96 overflow-y-auto">
                        <h3 class="text-lg font-semibold text-white mb-4">Worker User Guide</h3>
                        <p class="text-gray-300 mb-4">Welcome to the Worker Dashboard! As a Worker, your primary role is to
                            manage and update the tasks assigned to you. Follow the steps below to get started.</p>
                        <ul class="list-disc list-inside text-gray-300 space-y-2">
                            <li><strong>View Assigned Tasks:</strong> On the "My Tasks" page, you’ll see all tasks assigned
                                to you. Each task card shows the title, description, client, and current status.</li>
                            <li><strong>Update Task Status:</strong> Click the "Update Status" button on a task card to
                                change its status (e.g., from "Drafting" to "Review"). You can also upload attachments and
                                add notes.</li>
                            <li><strong>Upload Attachments:</strong> When updating a task, you can attach files (PDF, DOC,
                                PNG, etc.) to provide updates or deliverables.</li>
                            <li><strong>Add Notes:</strong> Use the notes field to communicate progress or issues to the
                                admin.</li>
                            <li><strong>View Orders:</strong> In the "Orders" section, you can see the orders associated
                                with your tasks.</li>
                            <li><strong>Settings:</strong> Update your profile and password in the "Settings" section.</li>
                        </ul>
                        <p class="text-gray-300 mt-4">For further assistance, reach out to your admin or contact support at
                            <a href="mailto:support@example.com"
                                class="text-blue-400 hover:underline">support@example.com</a>.
                        </p>
                    </div>
                @elseif (Auth::user()->role == 'client')
                    <div class="bg-gray-700 rounded-md p-6 max-h-96 overflow-y-auto">
                        <h3 class="text-lg font-semibold text-white mb-4">Client User Guide</h3>
                        <p class="text-gray-300 mb-4">Welcome to the Client Dashboard! As a Client, you can track your
                            orders and communicate with the team. Here’s how to use the system effectively.</p>
                        <ul class="list-disc list-inside text-gray-300 space-y-2">
                            <li><strong>Track Orders:</strong> Visit the "Track Order" page to view the status of your
                                orders. Enter your order number to see details like progress status and assigned workers.
                            </li>
                            <li><strong>View Order Details:</strong> Each order shows its current status (e.g., Pending, In
                                Progress, Completed) and any attachments or notes from the team.</li>
                            <li><strong>Communicate with the Team:</strong> Use the "Contact Us" page to send messages or
                                feedback to the admin team.</li>
                            <li><strong>Settings:</strong> Update your profile and password in the "Settings" section to
                                keep your account information up to date.</li>
                        </ul>
                        <p class="text-gray-300 mt-4">If you have any questions or need assistance, contact us at <a
                                href="mailto:support@example.com"
                                class="text-blue-400 hover:underline">support@example.com</a>.</p>
                    </div>
                @endif

                <!-- Contact Support Section -->
                <div class="bg-gray-800 rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-blue-300 mb-6 border-b border-gray-700 pb-2">Contact Support</h2>
                    <p class="mb-4">If you need further assistance, feel free to contact us:</p>

                    <!-- Contact Info -->
                    <div class="bg-gray-700 rounded-md p-6 flex space-x-8 items-center">
                        <div class="flex items-center">
                            <div class="bg-blue-600 rounded-full p-2 mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-blue-300">Email</h3>
                                <p><a href="mailto:support@jasaamanah.com"
                                        class="text-gray-300 hover:text-blue-300">support@jasaamanah.com</a></p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="bg-blue-600 rounded-full p-2 mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-blue-300">Phone</h3>
                                <p><a href="tel:+6281234567890" class="text-gray-300 hover:text-blue-300">+62
                                        812-3456-7890</a>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="bg-blue-600 rounded-full p-2 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="#e3e3e3">
                                    <path
                                        d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-blue-300">Send Message</h3>
                                <p><a href="{{ route('about') }}" class="text-gray-300 hover:text-blue-300">here
                                        directly</a>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
          document.addEventListener('DOMContentLoaded', function() {
            const collapseHeaders = document.querySelectorAll('.collapse-header');

            collapseHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const content = this.nextElementSibling;
                    const icon = this.querySelector('svg');

                    // Toggle the content visibility
                    if (content.style.display === 'block') {
                        content.style.display = 'none';
                        icon.style.transform = 'rotate(0deg)';
                    } else {
                        content.style.display = 'block';
                        icon.style.transform = 'rotate(180deg)';
                    }
                });
            });

            // Hide all collapse contents initially
            document.querySelectorAll('.collapse-content').forEach(content => {
                content.style.display = 'none';
            });
        });
    </script>
@endsection

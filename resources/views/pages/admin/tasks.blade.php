@extends('layouts.user')

<div class="fixed bottom-6 right-6 z-50">
    <!-- Tombol Add -->
    <button data-popover-target="popover-left" data-popover-placement="left" type="button"
        data-modal-target="taskFormModal" data-modal-toggle="taskFormModal" onclick="openAddTaskModal()"
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
            <p>Add Task</p>
        </div>
        <div data-popper-arrow></div>
    </div>
</div>

@section('content')
    <div class="container mx-auto pt-8 text-gray-200">
        <!-- Header Section -->
        <div class="px-4 flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <!-- Search Input -->
            <input type="text" id="searchInput" placeholder="Search tasks..."
                class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300">
            <!-- Filter Dropdowns -->
            <div class="flex space-x-4">
                <select id="statusFilter"
                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 w-48">
                    <option value="">Filter by Status</option>
                    <option value="Drafting">Drafting</option>
                    <option value="Review">Review</option>
                    <option value="Finalizing">Finalizing</option>
                    <option value="Concepting">Concepting</option>
                    <option value="Designing">Designing</option>
                    <option value="Revising">Revising</option>
                    <option value="Planning">Planning</option>
                    <option value="Developing">Developing</option>
                    <option value="Testing">Testing</option>
                    <option value="Deployment">Deployment</option>
                </select>
                <select id="divisionFilter"
                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 w-48">
                    <option value="">Filter by Division</option>
                    <option value="legalitas">Legalitas</option>
                    <option value="design">Design</option>
                    <option value="website">Website</option>
                </select>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div
                class="bg-green-900 text-green-200 px-4 py-3 rounded-lg mb-6 shadow-lg flex items-center justify-between mx-4 animate-fade-in">
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

        <!-- Task Cards -->
        <div class="px-4">
            <div id="tasksBody" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($tasks as $task)
                    <div class="bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-xl transition-all duration-300 border border-gray-700"
                        data-status="{{ strtolower($task->status) }}" data-division="{{ strtolower($task->division) }}">
                        <!-- Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-white truncate" title="{{ $task->title }}">
                                {{ Str::limit($task->title, 20, '...') }}
                            </h3>
                            <span
                                class="text-xs text-gray-400 bg-gray-700 px-2 py-1 rounded-full">{{ $loop->iteration }}</span>
                        </div>

                        <!-- Task Details -->
                        <div class="space-y-3 text-sm text-gray-300">
                            <p><span class="font-medium text-gray-200">Description:</span>
                                <span class="tooltip" data-tooltip="{{ $task->description ?? 'No description' }}">
                                    {{ Str::limit($task->description ?? 'No description', 25, '...') }}
                                </span>
                            </p>
                            <p><span class="font-medium text-gray-200">Assigned To:</span>
                                <span class="tooltip" data-tooltip="{{ $task->assignedUser->name ?? 'Unassigned' }}">
                                    {{ Str::limit($task->assignedUser->name ?? 'Unassigned', 20, '...') }}
                                </span>
                            </p>
                            <p><span class="font-medium text-gray-200">Client:</span>
                                <span class="tooltip" data-tooltip="{{ $task->order->client->name ?? 'N/A' }}">
                                    {{ Str::limit($task->order->client->name ?? 'N/A', 20, '...') }}
                                </span>
                            </p>
                            <p><span class="font-medium text-gray-200">Order Number:</span>
                                {{ $task->order->order_number }}</p>
                            <p><span class="font-medium text-gray-200">Created At:</span>
                                {{ $task->created_at->format('Y-m-d H:i') }}</p>
                            <p><span class="font-medium text-gray-200">Notes:</span>
                                <span class="tooltip" data-tooltip="{{ $task->note ?? 'No notes' }}">
                                    {{ Str::limit($task->note ?? 'No notes', 25, '...') }}
                                </span>
                            </p>
                        </div>

                        <!-- Status and Division Badges -->
                        <div class="flex flex-wrap gap-2 mt-4 mb-5">
                            <span
                                class="division-badge px-2.5 py-1 rounded-full text-xs font-medium text-white 
                                {{ $task->division === 'legalitas' ? 'bg-purple-600' : ($task->division === 'design' ? 'bg-pink-600' : 'bg-blue-600') }}">
                                {{ ucfirst($task->division) }}
                            </span>
                            <span
                                class="status-badge px-2.5 py-1 rounded-full text-xs font-medium text-white 
                                {{ in_array($task->status, ['Finalizing', 'Deployment']) ? 'bg-green-600' : (in_array($task->status, ['Review', 'Revising', 'Testing']) ? 'bg-yellow-600' : 'bg-orange-600') }}">
                                {{ $task->status }}
                            </span>
                        </div>

                        <!-- Attachments -->
                        <div class="mb-5">
                            <p class="text-sm font-medium text-gray-200 mb-2">Attachments:</p>
                            @if ($task->file_attachment && count($task->file_attachment) > 0)
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($task->file_attachment as $file)
                                        @php
                                            $fileName = basename($file);
                                            $shortFileName =
                                                Str::length($fileName) > 15
                                                    ? Str::substr($fileName, 0, 12) . '...'
                                                    : $fileName;
                                        @endphp
                                        <button
                                            onclick="openAttachmentPreview('{{ Storage::url($file) }}', '{{ $fileName }}')"
                                            class="flex items-center gap-2 px-3 py-1 bg-gray-700 rounded-lg hover:bg-gray-600 transition-all duration-300 tooltip"
                                            data-tooltip="{{ $fileName }}">
                                            @if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['png', 'jpg', 'jpeg']))
                                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            @elseif (pathinfo($file, PATHINFO_EXTENSION) === 'pdf')
                                                <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                            @elseif (in_array(pathinfo($file, PATHINFO_EXTENSION), ['doc', 'docx']))
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                            @endif
                                            <span
                                                class="text-xs text-gray-300 truncate max-w-[100px]">{{ $shortFileName }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-400 text-xs italic">No attachments available</span>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3">
                            {{-- <button type="button"
                                class="status-button flex-1 px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-sm font-medium shadow-md transition-all duration-300 transform hover:scale-105 tooltip"
                                data-tooltip="Update Status" data-modal-target="statusModal"
                                data-modal-toggle="statusModal" data-task-id="{{ $task->id }}"
                                data-division="{{ $task->division }}" data-status="{{ $task->status }}"
                                onclick="openStatusModal('{{ $task->id }}', '{{ $task->division }}', '{{ $task->status }}')">
                                <span class="status-icon">
                                    @if ($task->status === 'Drafting' || $task->status === 'Concepting' || $task->status === 'Planning')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    @elseif ($task->status === 'Review' || $task->status === 'Designing' || $task->status === 'Developing')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @elseif ($task->status === 'Revising' || $task->status === 'Testing')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    @elseif ($task->status === 'Finalizing' || $task->status === 'Deployment')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </span>
                            </button> --}}
                            <button type="button"
                                class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium shadow-md transition-all duration-300 transform hover:scale-105 tooltip"
                                data-tooltip="Edit Task" data-modal-target="taskFormModal"
                                data-modal-toggle="taskFormModal" onclick="editTask('{{ $task->id }}')">
                                Edit
                            </button>
                            <button type="button"
                                class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium shadow-md transition-all duration-300 transform hover:scale-105 tooltip"
                                data-tooltip="Delete Task" onclick="deleteTask('{{ $task->id }}')">
                                Delete
                            </button>
                        </div>
                    </div>
                @empty
                    <div
                        class="bg-gray-800 rounded-lg shadow-md p-6 text-center text-gray-400 col-span-full border border-gray-700">
                        No tasks available at the moment.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        @if (method_exists($tasks, 'links'))
            <div class="mt-6 px-4">
                {{ $tasks->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
@endsection

@section('modals')
    <!-- Task Form Modal (Add/Edit) -->
    <div id="taskFormModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-gray-800 rounded-lg shadow transform transition-all duration-300 scale-95">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-700">
                    <h3 id="formTitle" class="text-xl font-semibold text-white">Add Task</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="taskFormModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 space-y-4">
                    <form id="taskForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="_method" name="_method" value="POST">
                        <input type="hidden" id="taskId" name="taskId" value="">

                        <div class="mb-4">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-200">Task Title</label>
                            <input type="text" id="title" name="title"
                                class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="description"
                                class="block mb-2 text-sm font-medium text-gray-200">Description</label>
                            <textarea id="description" name="description" rows="3"
                                class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="division" class="block mb-2 text-sm font-medium text-gray-200">Division</label>
                            <select id="division" name="division"
                                class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300"
                                required>
                                <option value="legalitas">Legalitas</option>
                                <option value="design">Design</option>
                                <option value="website">Website</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-200">Status</label>
                            <select id="status" name="status"
                                class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300"
                                required>
                                <option value="Drafting">Drafting</option>
                                <option value="Review">Review</option>
                                <option value="Finalizing">Finalizing</option>
                                <option value="Concepting">Concepting</option>
                                <option value="Designing">Designing</option>
                                <option value="Revising">Revising</option>
                                <option value="Planning">Planning</option>
                                <option value="Developing">Developing</option>
                                <option value="Testing">Testing</option>
                                <option value="Deployment">Deployment</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="assigned_to" class="block mb-2 text-sm font-medium text-gray-200">Assigned
                                To</label>
                            <select id="assigned_to" name="assigned_to"
                                class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300"
                                required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="order_id" class="block mb-2 text-sm font-medium text-gray-200">Order</label>
                            <select id="order_id" name="order_id"
                                class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300"
                                required>
                                <option value="" disabled selected>Select an order</option>
                                @foreach ($clients as $client)
                                    @if ($client->orders->isNotEmpty())
                                        @foreach ($client->orders as $order)
                                            <option value="{{ $order->id }}">{{ $order->order_number }}
                                                ({{ $client->name }})
                                            </option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="file_attachment" class="block mb-2 text-sm font-medium text-gray-200">File
                                Attachments</label>
                            <input type="file" id="file_attachment" name="file_attachment[]" multiple
                                class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300">
                            <p class="text-xs text-gray-400 mt-1">Allowed: PDF, DOC, DOCX, PNG, JPG, JPEG (Max: 2MB each)
                            </p>
                            <div id="current_file_container" class="hidden mt-2">
                                <p class="text-sm text-gray-300">Current files:</p>
                                <ul id="current_file_list" class="list-disc list-inside text-sm text-gray-300"></ul>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="note" class="block mb-2 text-sm font-medium text-gray-200">Notes</label>
                            <textarea id="note" name="note" rows="2"
                                class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300"></textarea>
                        </div>

                        <div class="flex items-center space-x-2">
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-all duration-300">
                                Save
                            </button>
                            <button type="button"
                                class="text-gray-300 bg-gray-700 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-600 font-medium rounded-lg text-sm px-5 py-2.5 transition-all duration-300"
                                data-modal-hide="taskFormModal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- Status Update Modal -->
    <div id="statusModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-gray-800 rounded-lg shadow transform transition-all duration-300 scale-95">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-700">
                    <h3 class="text-xl font-semibold text-white">Update Status</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="statusModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 space-y-4">
                    <form id="statusForm" method="POST">
                        @csrf
                        <input type="hidden" id="_method" name="_method" value="PATCH">
                        <input type="hidden" id="taskIdForStatus" name="task_id">

                        <div class="mb-4">
                            <label for="statusUpdate" class="block mb-2 text-sm font-medium text-gray-200">Status</label>
                            <select id="statusUpdate" name="status"
                                class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300"
                                required>
                                <!-- Options populated via JS -->
                            </select>
                        </div>

                        <div class="flex items-center space-x-2">
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-all duration-300">
                                Update
                            </button>
                            <button type="button"
                                class="text-gray-300 bg-gray-700 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-600 font-medium rounded-lg text-sm px-5 py-2.5 transition-all duration-300"
                                data-modal-hide="statusModal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Fixed Attachment Preview Modal -->
    <div id="attachmentPreviewModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-black bg-opacity-60 overflow-auto">
        <div class="relative p-4 w-full max-w-[90vw] max-h-[90vh] flex flex-col">
            <div
                class="relative bg-gray-800 rounded-lg shadow transform transition-all duration-300 scale-95 opacity-0 flex flex-col">
                <!-- Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-700 flex-shrink-0">
                    <h3 id="attachmentPreviewTitle" class="text-lg font-semibold text-white truncate max-w-[80%]">
                        Attachment Preview
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                        data-modal-hide="attachmentPreviewModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Content Area -->
                <div class="p-4 flex-grow overflow-auto bg-gray-900 rounded-b-lg">
                    <div id="attachmentPreviewContent" class="w-full h-full flex justify-center items-center">
                        <!-- Content will be dynamically loaded -->
                    </div>
                </div>

                <!-- Footer with Controls -->
                <div class="p-4 flex flex-wrap justify-center gap-3 flex-shrink-0 border-t border-gray-700">
                    <button id="zoomInButton"
                        class="hidden text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                        </svg>
                        Zoom In
                    </button>
                    <button id="zoomOutButton"
                        class="hidden text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 10H7m6 0h-3" />
                        </svg>
                        Zoom Out
                    </button>
                    <a id="attachmentDownloadLink" href="#" download
                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        .animate-slide-in {
            animation: slideIn 0.5s ease-in-out;
        }

        .modal-open {
            transform: scale(1) !important;
            opacity: 1 !important;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .tooltip {
            position: relative;
        }

        .tooltip:before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4B5563;
            color: #D1D5DB;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s;
            z-index: 10;
        }

        .tooltip:hover:before {
            opacity: 1;
            visibility: visible;
        }

        .spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #attachmentPreviewContent {
            min-height: 200px;
        }
    </style>
<!-- Tambahkan SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Tambahkan PDF.js untuk preview PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.worker.min.js';

    // Status options berdasarkan divisi
    const statusOptions = {
        'legalitas': ['Drafting', 'Review', 'Finalizing'],
        'design': ['Concepting', 'Designing', 'Revising', 'Finalizing'],
        'website': ['Planning', 'Developing', 'Testing', 'Deployment']
    };

    // Search and Filter Functionality
    function applyFilters() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
        const divisionFilter = document.getElementById('divisionFilter').value.toLowerCase();
        const cards = document.querySelectorAll('#tasksBody > div');

        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            const status = card.getAttribute('data-status') || '';
            const division = card.getAttribute('data-division') || '';

            const matchesSearch = text.includes(searchTerm);
            const matchesStatus = !statusFilter || status === statusFilter;
            const matchesDivision = !divisionFilter || division === divisionFilter;

            card.style.display = (matchesSearch && matchesStatus && matchesDivision) ? '' : 'none';
        });
    }

    // Event Listeners
    document.getElementById('searchInput').addEventListener('input', applyFilters);
    document.getElementById('statusFilter').addEventListener('change', applyFilters);
    document.getElementById('divisionFilter').addEventListener('change', applyFilters);
    document.addEventListener('DOMContentLoaded', applyFilters);

    // Open Add Task Modal
    function openAddTaskModal() {
        document.getElementById('formTitle').textContent = 'Add Task';
        document.getElementById('taskForm').action = '{{ route('admin.tasks.store') }}';
        document.getElementById('_method').value = 'POST';
        document.getElementById('taskId').value = '';
        document.getElementById('taskForm').reset();
        document.getElementById('current_file_container').classList.add('hidden');

        // Set status options based on division
        updateStatusOptions(document.getElementById('division').value, 'status');

        const modal = document.getElementById('taskFormModal');
        modal.classList.remove('hidden');
        setTimeout(() => modal.querySelector('.bg-gray-800').classList.add('modal-open'), 10);
    }

    // Edit Task
    function editTask(taskId) {
        fetch(`/admin/tasks/${taskId}`)
            .then(response => response.json())
            .then(task => {
                document.getElementById('formTitle').textContent = 'Edit Task';
                document.getElementById('taskForm').action = `/admin/tasks/${taskId}`;
                document.getElementById('_method').value = 'PUT';
                document.getElementById('taskId').value = task.id;
                document.getElementById('title').value = task.title;
                document.getElementById('description').value = task.description || '';
                document.getElementById('division').value = task.division;
                updateStatusOptions(task.division, 'status'); // Update status options
                document.getElementById('status').value = task.status;
                document.getElementById('assigned_to').value = task.assigned_to;
                document.getElementById('order_id').value = task.order_id;
                document.getElementById('note').value = task.note || '';

                const fileList = document.getElementById('current_file_list');
                fileList.innerHTML = '';
                if (task.file_attachment && task.file_attachment.length > 0) {
                    task.file_attachment.forEach(file => {
                        const li = document.createElement('li');
                        li.innerHTML = `<a href="${file}" target="_blank" class="text-blue-400 hover:underline">${file.split('/').pop()}</a>`;
                        fileList.appendChild(li);
                    });
                    document.getElementById('current_file_container').classList.remove('hidden');
                } else {
                    document.getElementById('current_file_container').classList.add('hidden');
                }

                const modal = document.getElementById('taskFormModal');
                modal.classList.remove('hidden');
                setTimeout(() => modal.querySelector('.bg-gray-800').classList.add('modal-open'), 10);
            })
            .catch(error => {
                console.error('Error fetching task:', error);
                alert('Failed to load task data.');
            });
    }

    // Update Status Options based on Division
    function updateStatusOptions(division, selectId) {
        const statusSelect = document.getElementById(selectId);
        statusSelect.innerHTML = ''; // Kosongkan opsi sebelumnya
        const options = statusOptions[division] || [];

        if (options.length === 0) {
            const option = document.createElement('option');
            option.value = '';
            option.textContent = '-- Select Division First --';
            statusSelect.appendChild(option);
            statusSelect.disabled = true;
        } else {
            options.forEach(status => {
                const option = document.createElement('option');
                option.value = status;
                option.textContent = status;
                statusSelect.appendChild(option);
            });
            statusSelect.disabled = false;
        }
    }

    // Event listener untuk perubahan division di task form
    document.getElementById('division').addEventListener('change', function() {
        updateStatusOptions(this.value, 'status');
    });

    // // Open Status Update Modal
    // function openStatusModal(taskId, division, currentStatus) {
    //     document.getElementById('taskIdForStatus').value = taskId;
    //     document.getElementById('statusForm').action = `/admin/tasks/${taskId}/status`;

    //     const statusSelect = document.getElementById('statusUpdate');
    //     statusSelect.innerHTML = ''; // Kosongkan opsi sebelumnya

    //     const options = statusOptions[division] || [];
    //     options.forEach(status => {
    //         const option = document.createElement('option');
    //         option.value = status;
    //         option.textContent = status;
    //         if (status === currentStatus) {
    //             option.selected = true;
    //         }
    //         statusSelect.appendChild(option);
    //     });

    //     const modal = document.getElementById('statusModal');
    //     modal.classList.remove('hidden');
    //     setTimeout(() => modal.querySelector('.bg-gray-800').classList.add('modal-open'), 10);
    // }

    // Form Submission Handler untuk Task
    document.getElementById('taskForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const method = document.getElementById('_method').value;
        const url = this.action;

        Swal.fire({
            title: 'Saving Task...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => { throw data; });
                }
                return response.json();
            })
            .then(data => {
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    document.getElementById('taskFormModal').classList.add('hidden');
                    location.reload();
                });
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'Failed to save task.',
                    icon: 'error'
                });
            });
    });

    // // Form Submission Handler untuk Status
    // document.getElementById('statusForm').addEventListener('submit', function(e) {
    //     e.preventDefault();
    //     const formData = new FormData(this);
    //     const method = document.getElementById('_method').value;
    //     const url = this.action;

    //     Swal.fire({
    //         title: 'Updating Status...',
    //         allowOutsideClick: false,
    //         didOpen: () => {
    //             Swal.showLoading();
    //         }
    //     });

    //     fetch(url, {
    //             method: 'POST', // Gunakan POST karena method override di Laravel
    //             body: formData,
    //             headers: {
    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
    //                 'Accept': 'application/json'
    //             }
    //         })
    //         .then(response => {
    //             if (!response.ok) {
    //                 return response.json().then(data => { throw data; });
    //             }
    //             return response.json();
    //         })
    //         .then(data => {
    //             Swal.fire({
    //                 title: 'Success!',
    //                 text: `Task status updated to "${data.task.status}". Order status: "${data.order_status}".`,
    //                 icon: 'success',
    //                 timer: 2000,
    //                 showConfirmButton: false
    //             }).then(() => {
    //                 document.getElementById('statusModal').classList.add('hidden');
    //                 location.reload();
    //             });
    //         })
    //         .catch(error => {
    //             Swal.fire({
    //                 title: 'Error!',
    //                 text: error.message || 'Failed to update status.',
    //                 icon: 'error'
    //             });
    //         });
    // });

    // Delete Task with SweetAlert2
    function deleteTask(taskId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/tasks/${taskId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => { throw data; });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.last_task) {
                            Swal.fire({
                                title: 'Delete Order as well?',
                                text: 'This was the last task for the order. Do you want to delete the order too?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Yes, delete Order',
                                cancelButtonText: 'No, keep Order'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    fetch(`/admin/orders/${data.order_id}`, {
                                            method: 'DELETE',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            }
                                        })
                                        .then(response => {
                                            if (!response.ok) throw response.json();
                                            return response.json();
                                        })
                                        .then(() => {
                                            Swal.fire('Deleted!', 'Order and Task have been deleted.', 'success')
                                                .then(() => location.reload());
                                        })
                                        .catch(error => {
                                            Swal.fire('Error', 'Failed to delete order.', 'error');
                                        });
                                } else {
                                    Swal.fire('Deleted!', 'Task has been deleted.', 'success')
                                        .then(() => location.reload());
                                }
                            });
                        } else {
                            Swal.fire('Deleted!', 'Task has been deleted.', 'success')
                                .then(() => location.reload());
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'Failed to delete task.', 'error');
                    });
            }
        });
    }

    // Open Attachment Preview
    function openAttachmentPreview(fileUrl, fileName) {
        const modal = document.getElementById('attachmentPreviewModal');
        const title = document.getElementById('attachmentPreviewTitle');
        const content = document.getElementById('attachmentPreviewContent');
        const downloadLink = document.getElementById('attachmentDownloadLink');
        const zoomInButton = document.getElementById('zoomInButton');
        const zoomOutButton = document.getElementById('zoomOutButton');

        let zoomLevel = 1;
        let contentElement = null;

        title.textContent = `Preview: ${fileName}`;
        downloadLink.href = fileUrl;
        content.innerHTML = '<div class="spinner mx-auto text-white"></div>';
        zoomInButton.classList.add('hidden');
        zoomOutButton.classList.add('hidden');

        const extension = fileName.split('.').pop().toLowerCase();

        if (['png', 'jpg', 'jpeg'].includes(extension)) {
            const img = document.createElement('img');
            img.src = fileUrl;
            img.className = 'max-w-full max-h-[70vh] object-contain transition-transform duration-200';
            img.style.transform = `scale(${zoomLevel})`;

            img.onload = () => {
                content.innerHTML = '';
                content.appendChild(img);
                contentElement = img;
                zoomInButton.classList.remove('hidden');
                zoomOutButton.classList.remove('hidden');
            };
            img.onerror = () => {
                content.innerHTML = '<p class="text-red-400">Failed to load image. Please download it.</p>';
            };

            zoomInButton.onclick = () => {
                zoomLevel = Math.min(zoomLevel + 0.2, 3);
                contentElement.style.transform = `scale(${zoomLevel})`;
            };
            zoomOutButton.onclick = () => {
                zoomLevel = Math.max(zoomLevel - 0.2, 0.5);
                contentElement.style.transform = `scale(${zoomLevel})`;
            };
        } else if (extension === 'pdf') {
            content.innerHTML = '<canvas id="pdfCanvas" class="max-w-full max-h-[70vh]"></canvas>';
            const loadingTask = pdfjsLib.getDocument(fileUrl);
            loadingTask.promise.then(pdf => {
                pdf.getPage(1).then(page => {
                    const canvas = document.getElementById('pdfCanvas');
                    const context = canvas.getContext('2d');
                    const scale = Math.min(
                        (window.innerWidth * 0.9) / page.getViewport({ scale: 1 }).width,
                        (window.innerHeight * 0.7) / page.getViewport({ scale: 1 }).height
                    );
                    const viewport = page.getViewport({ scale: scale });

                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };
                    page.render(renderContext).promise.then(() => {
                        console.log('PDF page rendered');
                    });
                }).catch(error => {
                    content.innerHTML = '<p class="text-red-400">Failed to load PDF page. Please download to view.</p>';
                    console.error('Error rendering PDF page:', error);
                });
            }).catch(error => {
                content.innerHTML = '<p class="text-red-400">Failed to load PDF. Please download to view.</p>';
                console.error('Error loading PDF:', error);
            });
        } else {
            content.innerHTML = '<p class="text-gray-400">Preview not available for this file type. Please download to view.</p>';
        }

        modal.classList.remove('hidden');
        setTimeout(() => {
            const modalContent = modal.querySelector('.bg-gray-800');
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('modal-open');
        }, 10);
    }

    // Close Modal Handler
    document.querySelectorAll('[data-modal-hide]').forEach(button => {
        button.addEventListener('click', () => {
            const modalId = button.getAttribute('data-modal-hide');
            const modal = document.getElementById(modalId);
            const modalContent = modal.querySelector('.bg-gray-800');
            modalContent.classList.remove('modal-open');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => modal.classList.add('hidden'), 300);
        });
    });
</script>
@endsection
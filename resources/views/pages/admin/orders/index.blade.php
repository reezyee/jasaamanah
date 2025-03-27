    @extends('layouts.user')

    <div class="fixed bottom-6 right-6 z-50">
        <!-- Tombol Add -->
        <button data-popover-target="popover-left" data-popover-placement="left" type="button"
            data-modal-target="orderFormModal" data-modal-toggle="orderFormModal" onclick="openAddOrderModal()"
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
                <p>Add Order</p>
            </div>
            <div data-popper-arrow></div>
        </div>
    </div>

    @section('content')
        <div class="container mx-auto pt-8 text-gray-200">
            <!-- Header Section -->
            <div class="px-4 flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                <input type="text" id="searchInput" placeholder="Search order numbers..."
                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 transition-all duration-300">
                <div class="flex flex-col sm:flex-row gap-4">
                    <select id="statusFilter"
                        class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-48">
                        <option value="">All Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Processing">Processing</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                    <select id="divisionFilter"
                        class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-48">
                        <option value="">All Divisions</option>
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
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                    <button type="button" class="text-green-200 hover:text-white" onclick="this.parentElement.remove()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Orders Card Grid -->
            <div class="px-4">
                <div id="ordersBody" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($orders as $order)
                        <div class="bg-gray-800 rounded-lg shadow-md p-6 hover:shadow-xl transition-all duration-300 border border-gray-700"
                            data-status="{{ strtolower($order->status) }}"
                            data-division="{{ strtolower($order->division) }}">
                            <!-- Header -->
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-white truncate" title="{{ $order->order_number }}">
                                    {{ Str::limit($order->order_number, 20, '...') }}
                                </h3>
                                <span
                                    class="text-xs text-gray-400 bg-gray-700 px-2 py-1 rounded-full">{{ $loop->iteration }}</span>
                            </div>

                            <!-- Order Details -->
                            <div class="space-y-3 text-sm text-gray-300">
                                <p><span class="font-medium text-gray-200">Client:</span>
                                    <span class="tooltip"
                                        data-tooltip="{{ $order->client->name }}">{{ Str::limit($order->client->name, 20, '...') }}</span>
                                </p>
                                <p><span class="font-medium text-gray-200">Service Type:</span> {{ $order->service_type }}
                                </p>
                                <p><span class="font-medium text-gray-200">Service:</span>
                                    {{ $order->service->name ?? 'N/A' }}
                                </p>
                                <p><span class="font-medium text-gray-200">Est. Completion:</span>
                                    {{ $order->estimated_completion }}</p>
                            </div>

                            <!-- Status and Division Badges -->
                            <div class="flex flex-wrap gap-2 mt-4 mb-5">
                                <span
                                    class="division-badge px-2.5 py-1 rounded-full text-xs font-medium text-white 
                                    {{ $order->division === 'legalitas' ? 'bg-purple-600' : ($order->division === 'design' ? 'bg-pink-600' : 'bg-blue-600') }}">
                                    {{ ucfirst($order->division) }}
                                </span>
                                <span
                                    class="status-badge px-2.5 py-1 rounded-full text-xs font-medium text-white 
                                {{ $order->status === 'Completed' ? 'bg-green-600' : ($order->status === 'Processing' ? 'bg-yellow-600' : ($order->status === 'Cancelled' ? 'bg-red-600' : 'bg-orange-600')) }}">
                                    {{ $order->status }}
                                </span>

                                @php
                                    $statusColors = [
                                        'Drafting' => 'bg-green-600',
                                        'Review' => 'bg-yellow-600',
                                        'Finalizing' => 'bg-blue-600',

                                        'Concepting' => 'bg-purple-600',
                                        'Designing' => 'bg-indigo-600',
                                        'Revising' => 'bg-pink-600',

                                        'Planning' => 'bg-gray-600',
                                        'Developing' => 'bg-teal-600',
                                        'Testing' => 'bg-orange-600',
                                        'Deployment' => 'bg-red-600',
                                    ];

                                    $statusClass = $statusColors[$order->progress_status] ?? 'bg-gray-400';
                                @endphp

                                <span
                                    class="status-badge px-2.5 py-1 rounded-full text-xs font-medium text-white {{ $statusClass }}">
                                    {{ $order->progress_status }}
                                </span>

                            </div>

                            <!-- Attachments -->
                            <div class="mb-5">
                                <p class="text-sm font-medium text-gray-200 mb-2">Attachments:</p>
                                @if ($order->attachment && count($order->attachment) > 0)
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($order->attachment as $file)
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
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                @elseif (pathinfo($file, PATHINFO_EXTENSION) === 'pdf')
                                                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                        </path>
                                                    </svg>
                                                @elseif (in_array(pathinfo($file, PATHINFO_EXTENSION), ['doc', 'docx']))
                                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                        </path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
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
                                <button type="button"
                                    class="flex-1 px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-sm font-medium shadow-md transition-all duration-300 transform hover:scale-105 tooltip"
                                    data-tooltip="Edit Order" data-modal-target="orderFormModal"
                                    data-modal-toggle="orderFormModal" onclick="editOrder('{{ $order->id }}')">
                                    Edit
                                </button>
                                <button type="button"
                                    class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium shadow-md transition-all duration-300 transform hover:scale-105 tooltip"
                                    data-tooltip="Delete Order" onclick="deleteOrder('{{ $order->id }}')">
                                    Delete
                                </button>
                                <a href="{{ route('admin.orders.detail', $order->id) }}"
                                    class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium shadow-md transition-all duration-300 transform hover:scale-105 tooltip"
                                    data-tooltip="View Details">
                                    Detail
                                </a>
                            </div>
                        </div>
                    @empty
                        <div
                            class="bg-gray-800 rounded-lg shadow-md p-6 text-center text-gray-400 col-span-full border border-gray-700">
                            No orders available at the moment.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if (method_exists($orders, 'links'))
                <div class="mt-6 px-4">
                    {{ $orders->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    @endsection

    @section('modals')
        <!-- Order Form Modal (Add/Edit) -->
        <div id="orderFormModal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-gray-800 rounded-lg shadow transform transition-all duration-300 scale-95">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-700">
                        <h3 id="formTitle" class="text-xl font-semibold text-white">Add Order</h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="orderFormModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="p-4 md:p-5 space-y-4">
                        <form id="orderForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="_method" name="_method" value="PUT">
                            <input type="hidden" id="orderId" name="orderId" value="">

                            <div class="mb-4">
                                <label for="client_id" class="block mb-2 text-sm font-medium text-gray-200">Client</label>
                                <select id="client_id" name="client_id"
                                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300"
                                    required>
                                    <option value="">-- Select Client --</option>
                                    @foreach ($clients ?? [] as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="service_type" class="block mb-2 text-sm font-medium text-gray-200">Service
                                    Type</label>
                                <select id="service_type" name="service_type"
                                    onchange="setDivision(); updateServiceOptions();"
                                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300"
                                    required>
                                    <option value="">-- Select Service Type --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="assigned_to" class="block mb-2 text-sm font-medium text-gray-200">Assigned
                                    Worker</label>
                                <select id="assigned_to" name="assigned_to"
                                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300"
                                    required>
                                    <option value="">-- Select Worker --</option>
                                </select>
                                <p id="assigned_to_error" class="text-xs text-red-400 mt-1 hidden">No workers available
                                    for this service type.</p>
                            </div>

                            <div class="mb-4">
                                <label for="service_id"
                                    class="block mb-2 text-sm font-medium text-gray-200">Service</label>
                                <select id="service_id" name="service_id"
                                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300"
                                    required>
                                    <option value="">-- Select Service --</option>
                                </select>
                                <p id="service_id_error" class="text-xs text-red-400 mt-1 hidden">No services available
                                    for
                                    this service type.</p>
                            </div>

                            <div class="mb-4">
                                <label for="division"
                                    class="block mb-2 text-sm font-medium text-gray-200">Division</label>
                                <input type="text" id="division" name="division"
                                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300"
                                    readonly>
                            </div>

                            <div class="mb-4">
                                <label for="status" class="block mb-2 text-sm font-medium text-gray-200">Status</label>
                                <select id="status" name="status"
                                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300"
                                    required>
                                    <option value="Pending">Pending</option>
                                    <option value="Processing">Processing</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="progress_status" class="block mb-2 text-sm font-medium text-gray-200">Progress
                                    Status</label>
                                <select id="progress_status" name="progress_status"
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
                                <label for="estimated_completion"
                                    class="block mb-2 text-sm font-medium text-gray-200">Estimated Completion</label>
                                <input type="date" id="estimated_completion" name="estimated_completion"
                                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300">
                            </div>

                            <div class="mb-4">
                                <label for="attachment"
                                    class="block mb-2 text-sm font-medium text-gray-200">Attachments</label>
                                <input type="file" id="attachment" name="attachment[]" multiple
                                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300">
                                <p class="text-xs text-gray-400 mt-1">Allowed: PDF, DOC, DOCX, PNG, JPG, JPEG (Max: 2MB
                                    each)
                                </p>
                                <div id="current_attachment_container" class="hidden mt-2">
                                    <p class="text-sm text-gray-300">Current attachments:</p>
                                    <ul id="current_attachment_list" class="list-disc list-inside text-sm text-gray-300">
                                    </ul>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="admin_notes" class="block mb-2 text-sm font-medium text-gray-200">Admin
                                    Notes</label>
                                <textarea id="admin_notes" name="admin_notes" rows="2"
                                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all duration-300"></textarea>
                            </div>

                            <div class="flex items-center space-x-2">
                                <button type="submit"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition-all duration-300">
                                    Save
                                </button>
                                <button type="button"
                                    class="text-gray-300 bg-gray-700 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-600 font-medium rounded-lg text-sm px-5 py-2.5 transition-all duration-300"
                                    data-modal-hide="orderFormModal">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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
            /* Animation */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            .animate-fade-in {
                animation: fadeIn 0.5s ease-in-out;
            }

            .modal-open {
                transform: scale(1) !important;
                opacity: 1 !important;
            }

            /* Enhanced Card Styling */
            .card {
                transition: all 0.3s ease;
            }

            .card:hover {
                transform: translateY(-4px);
            }

            /* Tooltip Styles */
            .tooltip {
                position: relative;
            }

            .tooltip:before {
                content: attr(data-tooltip);
                position: absolute;
                bottom: 100%;
                left: 50%;
                transform: translateX(-50%);
                background-color: #1F2937;
                color: #D1D5DB;
                padding: 6px 10px;
                border-radius: 4px;
                font-size: 12px;
                white-space: nowrap;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.2s;
                z-index: 10;
                margin-bottom: 8px;
            }

            .tooltip:hover:before {
                opacity: 1;
                visibility: visible;
            }

            #attachmentPreviewModal {
                overscroll-behavior: contain;
            }

            #attachmentPreviewContent {
                min-height: 200px;
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
        </style>
        <!-- Tambahkan SweetAlert2 dan PDF.js -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
        <script>
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.worker.min.js';

            // Service data from server
            const categories = @json($categories);
            const workers = @json($workers); // Tambahkan data workers
            // Status options berdasarkan divisi
            const statusOptions = {
                'legalitas': ['Drafting', 'Review', 'Finalizing'],
                'design': ['Concepting', 'Designing', 'Revising', 'Finalizing'],
                'website': ['Planning', 'Developing', 'Testing', 'Deployment']
            };

            // Add Order Modal
            function openAddOrderModal() {
                document.getElementById('formTitle').textContent = 'Add Order';
                document.getElementById('orderForm').action = '{{ route('admin.orders.store') }}';
                document.getElementById('_method').value = 'POST';
                document.getElementById('orderId').value = '';
                document.getElementById('orderForm').reset();
                document.getElementById('current_attachment_container').classList.add('hidden');
                document.getElementById('service_id_error').classList.add('hidden');
                document.getElementById('assigned_to_error').classList.add('hidden'); // Reset pesan error
                setDivision();
                updateServiceOptions();
                updateProgressStatusOptions();
                updateAssignedWorkerOptions();
                const modal = document.getElementById('orderFormModal');
                modal.classList.remove('hidden');
                setTimeout(() => modal.querySelector('.bg-gray-800').classList.add('modal-open'), 10);
            }
            // Saat edit order
            function editOrder(id) {
                fetch(`/admin/orders/${id}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to fetch order data');
                        return response.json();
                    })
                    .then(order => {
                        document.getElementById('formTitle').textContent = 'Edit Order';
                        document.getElementById('orderForm').action = `/admin/orders/${id}`;
                        document.getElementById('_method').value = 'PUT';
                        document.getElementById('orderId').value = id;

                        document.getElementById('client_id').value = order.client_id || '';
                        document.getElementById('service_type').value = order.service_type || '';
                        updateServiceOptions();
                        setDivision();
                        updateProgressStatusOptions();
                        updateAssignedWorkerOptions(); // Memastikan pesan error diperbarui

                        setTimeout(() => {
                            document.getElementById('service_id').value = order.service_id || '';
                            document.getElementById('progress_status').value = order.progress_status || '';
                            document.getElementById('assigned_to').value = order.assigned_to || '';
                        }, 100);

                        document.getElementById('division').value = order.division || '';
                        document.getElementById('status').value = order.status || 'Pending';
                        document.getElementById('estimated_completion').value = order.estimated_completion ? order
                            .estimated_completion.split('T')[0] : '';
                        document.getElementById('admin_notes').value = order.admin_notes || '';

                        if (order.attachment && order.attachment.length > 0) {
                            document.getElementById('current_attachment_container').classList.remove('hidden');
                            const attachmentList = document.getElementById('current_attachment_list');
                            attachmentList.innerHTML = '';
                            order.attachment.forEach(file => {
                                const li = document.createElement('li');
                                const fileName = file.split('/').pop();
                                li.innerHTML =
                                    `<a href="/storage/${file}" target="_blank" class="text-blue-400 hover:underline">${fileName}</a>`;
                                attachmentList.appendChild(li);
                            });
                        } else {
                            document.getElementById('current_attachment_container').classList.add('hidden');
                        }

                        const modal = document.getElementById('orderFormModal');
                        modal.classList.remove('hidden');
                        setTimeout(() => modal.querySelector('.bg-gray-800').classList.add('modal-open'), 10);
                    })
                    .catch(error => {
                        console.error('Error fetching order:', error);
                        alert('Failed to load order data: ' + error.message);
                    });
            }

            // Delete Order with SweetAlert2
            function deleteOrder(id) {
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
                        fetch(`/admin/orders/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.json().then(data => {
                                        throw data;
                                    });
                                }
                                return response.json();
                            })
                            .then(data => {
                                Swal.fire('Deleted!', 'Order has been deleted.', 'success')
                                    .then(() => location.reload());
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire('Error', 'Failed to delete order: ' + (error.error ||
                                    'An unexpected error occurred.'), 'error');
                            });
                    }
                });
            }

            // Form Submission with AJAX for Order
            document.getElementById('orderForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                const url = this.action;
                formData.set('_method', document.getElementById('_method').value);

                fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw data;
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('orderFormModal').classList.add('hidden');
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Full error response:', error);
                        if (error.errors) {
                            const errorMessages = Object.values(error.errors).flat().join('\n');
                            alert('Validation failed:\n' + errorMessages);
                        } else if (error.error) {
                            alert('Failed to save order:\n' + error.error);
                        } else {
                            alert('Failed to save order: An unexpected error occurred.');
                        }
                    });
            });

            // Panggil saat Service Type berubah
            function setDivision() {
                const serviceType = document.getElementById('service_type').value;
                const divisionInput = document.getElementById('division');
                switch (serviceType) {
                    case 'Website':
                        divisionInput.value = 'website';
                        break;
                    case 'Legality':
                        divisionInput.value = 'legality';
                        break;
                    case 'Design':
                        divisionInput.value = 'design';
                        break;
                    default:
                        divisionInput.value = '';
                }
                updateProgressStatusOptions();
                updateAssignedWorkerOptions(); // Memastikan pesan error diperbarui
            }

            // Update Service Options Based on Service Type
            function updateServiceOptions() {
                const serviceType = document.getElementById('service_type').value;
                const serviceSelect = document.getElementById('service_id');
                const errorMessage = document.getElementById('service_id_error');

                serviceSelect.innerHTML = '<option value="">-- Select Service --</option>';

                if (!serviceType) {
                    errorMessage.classList.remove('hidden');
                    serviceSelect.disabled = true;
                    return;
                }

                const category = categories.find(cat => cat.name.toLowerCase() === serviceType.toLowerCase());

                if (category && category.services && category.services.length > 0) {
                    category.services.forEach(service => {
                        const option = document.createElement('option');
                        option.value = service.id;
                        option.textContent = service.name;
                        serviceSelect.appendChild(option);
                    });
                    errorMessage.classList.add('hidden');
                    serviceSelect.disabled = false;
                } else {
                    console.log('No services found for this category');
                    errorMessage.classList.remove('hidden');
                    serviceSelect.disabled = true;
                }
            }

            // Update Progress Status Options Based on Division
            function updateProgressStatusOptions() {
                const division = document.getElementById('division').value.toLowerCase();
                const progressStatusSelect = document.getElementById('progress_status');
                progressStatusSelect.innerHTML = ''; // Kosongkan opsi sebelumnya

                const options = statusOptions[division] || [];
                if (options.length === 0) {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = '-- Select Service Type First --';
                    progressStatusSelect.appendChild(option);
                    progressStatusSelect.disabled = true;
                } else {
                    options.forEach(status => {
                        const option = document.createElement('option');
                        option.value = status;
                        option.textContent = status;
                        progressStatusSelect.appendChild(option);
                    });
                    progressStatusSelect.disabled = false;
                }
            }

            // Update Assigned Worker Options Based on Division
            function updateAssignedWorkerOptions() {
                const division = document.getElementById('division').value.toLowerCase();
                const assignedToSelect = document.getElementById('assigned_to');
                const errorMessage = document.getElementById('assigned_to_error');

                assignedToSelect.innerHTML = '<option value="">-- Select Worker --</option>';

                if (!division) {
                    assignedToSelect.disabled = true;
                    errorMessage.classList.remove('hidden');
                    errorMessage.textContent = 'Please select a service type first.';
                    return;
                }

                const filteredWorkers = workers.filter(worker => worker.division.toLowerCase() === division);
                if (filteredWorkers.length > 0) {
                    filteredWorkers.forEach(worker => {
                        const option = document.createElement('option');
                        option.value = worker.id;
                        option.textContent = worker.name;
                        assignedToSelect.appendChild(option);
                    });
                    assignedToSelect.disabled = false;
                    errorMessage.classList.add('hidden');
                } else {
                    assignedToSelect.disabled = true;
                    errorMessage.classList.remove('hidden');
                    errorMessage.textContent = 'No workers available for this service type.';
                }
            }

            // Apply Filters
            function applyFilters() {
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
                const divisionFilter = document.getElementById('divisionFilter').value.toLowerCase();
                const cards = document.querySelectorAll('#ordersBody > div');

                cards.forEach(card => {
                    const text = card.textContent.toLowerCase();
                    const status = card.getAttribute('data-status') || '';
                    const division = card.getAttribute('data-division') || '';

                    const matchesSearch = text.includes(searchTerm);
                    const matchesStatus = !statusFilter || status === statusFilter;
                    const matchesDivision = !divisionFilter || division === divisionFilter;

                    card.style.display = (matchesSearch && matchesStatus && matchesDivision) ? '' : 'none';

                    console.log({
                        card: card.querySelector('h3').textContent,
                        status: status,
                        division: division,
                        statusFilter: statusFilter,
                        divisionFilter: divisionFilter,
                        matchesStatus: matchesStatus,
                        matchesDivision: matchesDivision
                    });
                });
            }

            // Event Listeners for Filters
            document.getElementById('searchInput').addEventListener('input', applyFilters);
            document.getElementById('statusFilter').addEventListener('change', applyFilters);
            document.getElementById('divisionFilter').addEventListener('change', applyFilters);
            document.addEventListener('DOMContentLoaded', applyFilters);

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
                                (window.innerWidth * 0.9) / page.getViewport({
                                    scale: 1
                                }).width,
                                (window.innerHeight * 0.7) / page.getViewport({
                                    scale: 1
                                }).height
                            );
                            const viewport = page.getViewport({
                                scale: scale
                            });

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
                            content.innerHTML =
                                '<p class="text-red-400">Failed to load PDF page. Please download to view.</p>';
                            console.error('Error rendering PDF page:', error);
                        });
                    }).catch(error => {
                        content.innerHTML = '<p class="text-red-400">Failed to load PDF. Please download to view.</p>';
                        console.error('Error loading PDF:', error);
                    });
                } else {
                    content.innerHTML =
                        '<p class="text-gray-400">Preview not available for this file type. Please download to view.</p>';
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

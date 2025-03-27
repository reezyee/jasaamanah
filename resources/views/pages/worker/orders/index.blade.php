@extends('layouts.user')

@section('content')
    <div class="container mx-auto pt-8 pb-12 text-gray-200">
        <!-- Header Section -->
        <div class="px-4 flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
            <input type="text" id="searchInput" placeholder="Search order numbers..."
                class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 transition-all duration-300">
            <select id="statusFilter"
                class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-full sm:w-48">
                <option value="">All Status</option>
                <option value="Pending">Pending</option>
                <option value="Processing">Processing</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Canceled</option>
            </select>
            <select id="divisionFilter"
                class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-full sm:w-48">
                <option value="">All Divisions</option>
                <option value="legalitas">Legalitas</option>
                <option value="design">Design</option>
                <option value="website">Website</option>
            </select>
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
                    <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl shadow-lg p-6 border border-gray-700 transform transition-all hover:shadow-xl"
                        data-status="{{ strtolower($order->status) }}" data-division="{{ strtolower($order->division) }}">
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
                                {{ $order->estimated_completion ? \Carbon\Carbon::parse($order->estimated_completion)->format('d M Y') : 'TBD' }}
                            </p>
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
                            <a href="{{ route('worker.orders.show', $order->id) }}"
                                class="flex w-full justify-center px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg text-sm font-medium shadow-md transition-all duration-300 transform hover:scale-105 tooltip"
                                data-tooltip="View Details">
                                Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div
                        class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl shadow-lg p-6 text-center text-gray-400 col-span-full border border-gray-700">
                        <svg class="w-16 h-16 mx-auto text-gray-500 mb-4 animate-bounce-slow" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-400 text-lg font-medium">No orders assigned to you</p>
                        <p class="text-gray-500 text-sm mt-2">Check back later for new assignments!</p>
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
        /* Animations */
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse-slow {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes bounce-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out forwards;
        }

        .animate-slide-up {
            animation: slide-up 0.5s ease-out forwards;
        }

        .animate-pulse-slow {
            animation: pulse-slow 2s infinite ease-in-out;
        }

        .animate-bounce-slow {
            animation: bounce-slow 3s infinite ease-in-out;
        }

        /* Smooth Transitions */
        .transition-all {
            transition: all 0.3s ease-out;
        }

        .hover\:scale-105:hover {
            transform: scale(1.05);
        }

        .hover\:shadow-xl:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
        }

        /* Tooltip Styles */
        .tooltip {
            position: relative;
        }

        .tooltip::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #4B5563;
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease;
            z-index: 10;
        }

        .tooltip:hover::after {
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

    <!-- Tambahkan PDF.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.worker.min.js';

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

        // Fade-in effect for the entire page
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.container').classList.add('animate-fade-in');

            // Animate cards sequentially
            const cards = document.querySelectorAll('#ordersBody > div');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.2}s`;
                card.classList.add('animate-slide-up');
            });

            // Hover effects for interactive elements
            const interactiveElements = document.querySelectorAll('a[href], button');
            interactiveElements.forEach(el => {
                el.addEventListener('mouseenter', () => el.classList.add('hover:scale-105'));
                el.addEventListener('mouseleave', () => el.classList.remove('hover:scale-105'));
            });
        });
    </script>
@endsection

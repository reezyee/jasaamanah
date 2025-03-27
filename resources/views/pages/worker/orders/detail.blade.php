@extends('layouts.user')

@section('content')
    <div class="container mx-auto pt-8 pb-12 text-gray-200">
        <!-- Header Section -->
        <div
            class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl shadow-lg p-6 mb-8 mx-4 border border-gray-700 transform transition-all hover:shadow-xl">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-white tracking-tight">{{ $order->order_number }}</h1>
                    <p class="text-sm text-gray-400 mt-1">Placed on <span
                            class="font-medium">{{ $order->created_at->format('d M Y') }}</span></p>
                </div>
                <span
                    class="mt-3 sm:mt-0 px-4 py-1 rounded-full text-sm font-medium text-white shadow-md animate-pulse-slow
                    {{ $order->status === 'Selesai' ? 'bg-green-600' : ($order->status === 'Diproses' ? 'bg-yellow-600' : ($order->status === 'Dibatalkan' ? 'bg-red-600' : 'bg-blue-600')) }}">
                    {{ $order->status }}
                </span>
            </div>

            <!-- Order Summary -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-sm">
                <div class="bg-gray-700 bg-opacity-50 rounded-lg p-3">
                    <p class="text-gray-400">Client</p>
                    <p class="font-medium text-white truncate" title="{{ $order->client->name }}">{{ $order->client->name }}
                    </p>
                </div>
                <div class="bg-gray-700 bg-opacity-50 rounded-lg p-3">
                    <p class="text-gray-400">Service</p>
                    <p class="font-medium text-white truncate" title="{{ $order->service->name ?? $order->service_type }}">
                        {{ $order->service->name ?? $order->service_type }}</p>
                </div>
                <div class="bg-gray-700 bg-opacity-50 rounded-lg p-3">
                    <p class="text-gray-400">Estimated Completion</p>
                    <p class="font-medium text-white">
                        {{ $order->estimated_completion ? $order->estimated_completion->format('d M Y') : 'TBD' }}</p>
                </div>
            </div>
        </div>

        <!-- Progress Section -->
        <div
            class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl shadow-lg p-6 mb-8 mx-4 border border-gray-700 transform transition-all hover:shadow-xl">
            <h2 class="text-xl font-semibold text-white mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Order Progress
            </h2>

            @php
                // Tentukan stages berdasarkan divisi
                $divisionStages = [
                    'legalitas' => [
                        'Order Placed' => [],
                        'Drafting' => ['Drafting'],
                        'Review' => ['Review'],
                        'Finalizing' => ['Finalizing'],
                    ],
                    'design' => [
                        'Order Placed' => [],
                        'Concepting' => ['Concepting'],
                        'Designing' => ['Designing'],
                        'Revising' => ['Revising'],
                        'Finalizing' => ['Finalizing'],
                    ],
                    'website' => [
                        'Order Placed' => [],
                        'Planning' => ['Planning'],
                        'Developing' => ['Developing'],
                        'Testing' => ['Testing'],
                        'Deployment' => ['Deployment'],
                    ],
                ];
                $stages = $divisionStages[$order->division] ?? [
                    'Order Placed' => [],
                    'In Progress' => [],
                    'Under Review' => [],
                    'Completed' => [],
                ];
                $stageKeys = array_keys($stages);

                // Hitung status task
                $taskStatuses = $order->tasks->pluck('status')->toArray();
                $totalTasks = $order->tasks->count();
                $completedTasks = $order->tasks->whereIn('status', end($stages))->count();

                // Tentukan current stage dan progress
                $currentStageIndex = 0;
                $progressPercentage = 0;

                if ($totalTasks > 0) {
                    // Cari stage paling maju yang memiliki task
                    foreach ($stages as $stage => $validStatuses) {
                        if (!empty($validStatuses) && $order->tasks->whereIn('status', $validStatuses)->count() > 0) {
                            $currentStageIndex = max($currentStageIndex, array_search($stage, $stageKeys));
                        }
                    }

                    // Jika semua task selesai, set ke stage terakhir
                    if ($completedTasks > 0 && $completedTasks === $totalTasks) {
                        $currentStageIndex = count($stages) - 1;
                        $progressPercentage = 100;
                    } else {
                        // Hitung progress berdasarkan posisi stage
                        $progressPercentage = min(100, ($currentStageIndex / (count($stages) - 1)) * 100);
                    }
                } else {
                    // Jika tidak ada task, gunakan status order
                    if ($order->status === 'Selesai') {
                        $currentStageIndex = count($stages) - 1;
                        $progressPercentage = 100;
                    } elseif ($order->status === 'Dibatalkan') {
                        $currentStageIndex = 1;
                        $progressPercentage = 25;
                    } else {
                        $currentStageIndex = 1; // Default ke stage kedua (In Progress)
                        $progressPercentage = 25;
                    }
                }

                // Tambahan untuk status Dibatalkan
                if ($order->status === 'Dibatalkan') {
                    $currentStageIndex = 1;
                    $progressPercentage = 25;
                }
            @endphp

            <div class="relative">
                <!-- Progress Bar -->
                <div class="h-3 bg-gray-700 rounded-full overflow-hidden shadow-inner mb-4">
                    <div class="h-full bg-gradient-to-r from-blue-500 to-blue-700 rounded-full transition-all duration-700 ease-out relative"
                        style="width: {{ $progressPercentage }}%">
                        <div class="absolute inset-0 bg-blue-400 opacity-30 animate-pulse"></div>
                    </div>
                </div>

                <!-- Stages -->
                <div class="flex justify-between mt-4 text-sm relative">
                    @foreach ($stages as $stage => $validStatuses)
                        @php
                            $index = array_search($stage, $stageKeys);
                            $isComplete =
                                $index < $currentStageIndex ||
                                ($index === $currentStageIndex && $completedTasks === $totalTasks && $totalTasks > 0);
                            $isCurrent = $index === $currentStageIndex && !$isComplete;
                            $isPending =
                                $index > $currentStageIndex ||
                                ($totalTasks === 0 && $index > 1 && $order->status !== 'Selesai');

                            // Tentukan status tooltip
                            $tooltipStatus = $isComplete ? 'Completed' : ($isCurrent ? 'In Progress' : 'Pending');
                            if ($order->status === 'Dibatalkan' && $index >= 1) {
                                $tooltipStatus = $index === 1 ? 'Cancelled' : 'Not Started';
                            }

                            // Cek apakah stage memiliki task yang sesuai
                            $stageTaskCount = $order->tasks->whereIn('status', $validStatuses)->count();
                        @endphp
                        <div class="text-center relative z-10 tooltip"
                            data-tooltip="{{ $stage }} - {{ $tooltipStatus }}{{ $stageTaskCount > 0 ? ' (' . $stageTaskCount . ' task' . ($stageTaskCount > 1 ? 's' : '') . ')' : '' }}">
                            <div
                                class="w-6 h-6 mx-auto rounded-full border-2 transition-all duration-300
                        {{ $isComplete ? 'bg-blue-600 border-blue-600' : ($isCurrent ? 'bg-yellow-600 border-yellow-600' : 'border-gray-500 bg-gray-800') }} 
                        {{ $isCurrent ? 'ring-4 ring-yellow-400 ring-opacity-50 scale-110' : '' }}">
                                @if ($isComplete)
                                    <svg class="w-4 h-4 mx-auto text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @elseif ($isCurrent)
                                    <svg class="w-4 h-4 mx-auto text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                            </div>
                            <p
                                class="mt-2 {{ $isComplete ? 'text-white font-medium' : ($isCurrent ? 'text-yellow-300' : 'text-gray-400') }}">
                                {{ $stage }}</p>
                        </div>
                        @if ($index < count($stages) - 1)
                            <div class="absolute top-2 left-0 right-0 h-1 bg-gray-700 -z-10"
                                style="margin-left: 25%; width: 50%;">
                                <div class="h-full bg-blue-600 transition-all duration-700"
                                    style="width: {{ $index < $currentStageIndex ? '100%' : ($index === $currentStageIndex ? $progressPercentage - ($index * 100) / (count($stages) - 1) . '%' : '0%') }}">
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Tracking Details (Timeline) -->
        <div
            class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl shadow-lg p-6 mb-8 mx-4 border border-gray-700 transform transition-all hover:shadow-xl">
            <h2 class="text-xl font-semibold text-white mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01">
                    </path>
                </svg>
                Tracking History
            </h2>
            <div class="relative max-h-96 overflow-y-auto custom-scrollbar">
                @php
                    // Gabungkan semua entri timeline (order dan task)
                    $timelineEntries = [];

                    // Entri untuk Order Created
                    $timelineEntries[] = [
                        'type' => 'order',
                        'event' => 'Order Created',
                        'description' => "Order #{$order->order_number} was placed.",
                        'timestamp' => $order->created_at,
                        'status' => 'Order Created',
                    ];

                    // Entri untuk perubahan status order (jika ada)
                    if ($order->status !== 'Pending' && $order->updated_at->gt($order->created_at)) {
                        $timelineEntries[] = [
                            'type' => 'order',
                            'event' => 'Order Status Changed',
                            'description' => "Order status changed to {$order->status}.",
                            'timestamp' => $order->updated_at,
                            'status' => $order->status,
                        ];
                    }

                    // Entri untuk task
                    foreach ($order->tasks as $task) {
                        $timelineEntries[] = [
                            'type' => 'task',
                            'event' => 'Task Created',
                            'title' => $task->title,
                            'description' => $task->description ?? 'No description provided',
                            'timestamp' => $task->created_at,
                            'status' => $task->status,
                            'task' => $task,
                        ];

                        // Jika task diupdate (status berubah)
                        if ($task->updated_at->gt($task->created_at)) {
                            $timelineEntries[] = [
                                'type' => 'task',
                                'event' => 'Task Updated',
                                'title' => $task->title,
                                'description' => "Task status updated to {$task->status}.",
                                'timestamp' => $task->updated_at,
                                'status' => $task->status,
                                'task' => $task,
                            ];
                        }
                    }

                    // Urutkan entri berdasarkan timestamp (ascending)
                    $timelineEntries = collect($timelineEntries)->sortBy('timestamp')->values();
                @endphp

                @if ($timelineEntries->count() > 0)
                    <div class="relative border-l-2 border-gray-600 pl-6">
                        @foreach ($timelineEntries as $entry)
                            <div class="mb-8 animate-slide-up relative">
                                @php
                                    // Tentukan warna berdasarkan status
                                    $colorClass = 'bg-blue-600'; // Default
                                    if ($entry['type'] === 'order') {
                                        if ($entry['status'] === 'Order Created') {
                                            $colorClass = 'bg-blue-600';
                                        } elseif ($entry['status'] === 'Selesai') {
                                            $colorClass = 'bg-green-600';
                                        } elseif ($entry['status'] === 'Dibatalkan') {
                                            $colorClass = 'bg-red-600';
                                        } elseif ($entry['status'] === 'Diproses') {
                                            $colorClass = 'bg-yellow-600';
                                        }
                                    } elseif ($entry['type'] === 'task') {
                                        if (in_array($entry['status'], ['Finalizing', 'Deployment'])) {
                                            $colorClass = 'bg-green-600';
                                        } elseif (in_array($entry['status'], ['Review', 'Revising', 'Testing'])) {
                                            $colorClass = 'bg-yellow-600';
                                        } elseif ($entry['status'] === 'Dibatalkan') {
                                            $colorClass = 'bg-red-600';
                                        } else {
                                            $colorClass = 'bg-blue-600';
                                        }
                                    }
                                @endphp
                                <div class="absolute -left-8 top-1 w-4 h-4 rounded-full {{ $colorClass }}"></div>
                                <div
                                    class="bg-gray-700 bg-opacity-30 p-4 rounded-lg transition-all duration-300 hover:bg-opacity-50">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm font-medium text-white">
                                                {{ $entry['event'] }}
                                                @if (isset($entry['title']))
                                                    - {{ $entry['title'] }}
                                                @endif
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">{{ $entry['description'] }}</p>
                                        </div>
                                        @if (isset($entry['status']))
                                            <span
                                                class="text-xs text-gray-500 bg-gray-800 px-2 py-1 rounded-full">{{ $entry['status'] }}</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Date:
                                        {{ $entry['timestamp']->format('d M Y, H:i') }}</p>
                                    @if (isset($entry['task']))
                                        @if ($entry['task']->assignedUser)
                                            <p class="text-xs text-gray-400 mt-1">Assigned to:
                                                {{ $entry['task']->assignedUser->name }}</p>
                                        @endif
                                        @if ($entry['task']->note)
                                            <p class="text-xs text-gray-400 mt-1 italic">Note: {{ $entry['task']->note }}
                                            </p>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 mx-auto text-gray-500 mb-4 animate-bounce-slow" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-gray-400 text-lg font-medium">No tracking history yet</p>
                        <p class="text-gray-500 text-sm mt-2">Stay tuned for updates as we process your order!</p>
                    </div>
                @endif
            </div>
        </div>

        

        <!-- Back Button -->
        <div class="px-4 mt-6">
            <a href="{{ route('worker.orders.index') }}"
                class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg text-sm font-medium shadow-md transition-all duration-300 transform hover:scale-105">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Orders
            </a>
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

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1F2937;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4B5563;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #6B7280;
        }

        /* Progress Bar */
        .shadow-inner {
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Tooltip */
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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fade-in effect for the entire page
            document.querySelector('.container').classList.add('animate-fade-in');

            // Animate tracking items sequentially
            const trackingItems = document.querySelectorAll('.animate-slide-up');
            trackingItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.2}s`;
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

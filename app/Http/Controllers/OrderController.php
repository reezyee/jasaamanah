<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Task;
use App\Models\User;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['client', 'tasks', 'assignedWorker', 'service'])->latest()->paginate(10);
        $workers = User::where('role', 'worker')->get();
        $clients = User::where('role', 'client')->get();
        $categories = Category::with('services')->get();

        // Debugging
        Log::info('Categories with services:', $categories->toArray());
        foreach ($categories as $category) {
            Log::info("Category {$category->name} has " . $category->services->count() . " services");
        }

        return view('pages.admin.orders.index', compact('orders', 'workers', 'clients', 'categories'))
            ->with(['title' => 'Order Management']);
    }

    public function show($id)
    {
        try {
            $order = Order::with(['client', 'tasks', 'assignedWorker', 'service'])->findOrFail($id);

            // Format tanggal untuk konsistensi dengan format input date HTML
            if ($order->estimated_completion) {
                $order->estimated_completion = date('Y-m-d', strtotime($order->estimated_completion));
            }

            return response()->json($order);
        } catch (\Exception $e) {
            Log::error('Error retrieving order: ' . $e->getMessage());
            return response()->json(['error' => 'Order not found'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Store request data:', $request->all());

            $validServiceTypes = Category::pluck('name')->toArray();
            $request->validate([
                'client_id' => 'required|exists:users,id',
                'service_type' => ['required', 'in:' . implode(',', $validServiceTypes)],
                'service_id' => 'required|exists:services,id',
                'estimated_completion' => 'required|date',
                'assigned_to' => 'required|exists:users,id',
                'attachment.*' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048',
                'admin_notes' => 'nullable|string',
            ]);

            $division = match ($request->service_type) {
                'Website' => 'website',
                'Legality' => 'legalitas',
                'Design' => 'design',
                default => throw new \Exception('Invalid service type: ' . $request->service_type),
            };

            $orderNumber = 'ORD-' . Str::random(6);
            while (Order::where('order_number', $orderNumber)->exists()) {
                $orderNumber = 'ORD-' . Str::random(6);
            }

            $attachmentPaths = [];
            if ($request->hasFile('attachment')) {
                Log::info('Uploading files:', $request->file('attachment'));
                foreach ($request->file('attachment') as $file) {
                    $path = $file->store('orders', 'public');
                    Log::info('File uploaded to: ' . $path);
                    $attachmentPaths[] = $path;
                }
            }

            $orderData = [
                'order_number' => $orderNumber,
                'order_date' => now(),
                'status' => 'Pending',
                'progress_status' => match ($division) {
                    'legalitas' => 'Drafting',
                    'design' => 'Concepting',
                    'website' => 'Planning',
                },
                'admin_notes' => $request->admin_notes,
                'attachment' => $attachmentPaths,
                'client_id' => $request->client_id,
                'estimated_completion' => $request->estimated_completion,
                'service_type' => $request->service_type,
                'service_id' => $request->service_id,
                'division' => $division,
                'assigned_to' => $request->assigned_to,
            ];

            Log::info('Creating order with data:', $orderData);
            $order = Order::create($orderData);
            Log::info('Order created:', $order->toArray());

            $defaultTitle = "Task for Order #$orderNumber";
            $worker = User::find($request->assigned_to);
            if ($worker) {
                // Fetch the service name for the description
                $service = Service::find($request->service_id);
                $description = "Service: {$order->service_type} - " . ($service ? $service->name : 'N/A');

                $taskData = [
                    'title' => $defaultTitle,
                    'description' => $description,
                    'division' => $division,
                    'status' => $order->progress_status,
                    'assigned_to' => $worker->id,
                    'order_id' => $order->id,
                    'file_attachment' => $attachmentPaths,
                    'note' => $order->admin_notes,
                ];
                Log::info('Creating task with data:', $taskData);
                $task = Task::create($taskData);
                Log::info('Task created for order: ' . $order->id, ['task' => $task->toArray()]);
            } else {
                Log::warning('Worker not found for assigned_to: ' . $request->assigned_to);
            }

            return response()->json(['message' => 'Order created successfully.', 'order' => $order->load('tasks')], 201);
        } catch (\Exception $e) {
            Log::error('Failed to save order: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to save order: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Update request data:', $request->all());

            $order = Order::findOrFail($id);
            if (auth()->user()->role !== 'admin' && auth()->user()->division !== $order->division) {
                abort(403, 'Unauthorized');
            }

            $validServiceTypes = Category::pluck('name')->toArray();
            $request->validate([
                'client_id' => 'required|exists:users,id',
                'service_type' => ['required', 'in:' . implode(',', $validServiceTypes)],
                'service_id' => 'required|exists:services,id',
                'status' => 'required|in:Pending,Diproses,Selesai,Dibatalkan',
                'progress_status' => 'required|in:Drafting,Review,Finalizing,Concepting,Designing,Revising,Planning,Developing,Testing,Deployment',
                'assigned_to' => 'required|exists:users,id',
                'admin_notes' => 'nullable|string',
                'attachment.*' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048',
                'estimated_completion' => 'nullable|date',
            ]);

            $division = match ($request->service_type) {
                'Website' => 'website',
                'Legality' => 'legalitas',
                'Design' => 'design',
                default => throw new \Exception('Invalid service type: ' . $request->service_type),
            };

            $attachmentPaths = $order->attachment ?? [];
            if ($request->hasFile('attachment')) {
                foreach ($attachmentPaths as $path) {
                    Storage::disk('public')->delete($path);
                }
                $attachmentPaths = [];
                foreach ($request->file('attachment') as $file) {
                    $attachmentPaths[] = $file->store('orders', 'public');
                }
            }

            $updateData = [
                'client_id' => $request->client_id,
                'service_type' => $request->service_type,
                'service_id' => $request->service_id,
                'status' => $request->status,
                'progress_status' => $request->progress_status,
                'admin_notes' => $request->admin_notes,
                'estimated_completion' => $request->estimated_completion,
                'division' => $division,
                'assigned_to' => $request->assigned_to,
                'attachment' => $attachmentPaths,
            ];

            $order->update($updateData);

            // Sinkronisasi ke Task
            $order->tasks()->update([
                'division' => $division,
                'status' => $request->progress_status,
                'assigned_to' => $request->assigned_to,
                'file_attachment' => $attachmentPaths,
                'note' => $request->admin_notes,
            ]);

            return response()->json(['message' => 'Order updated successfully.', 'order' => $order->load('tasks')], 200);
        } catch (\Exception $e) {
            Log::error('Failed to update order: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to update order: ' . $e->getMessage()], 500);
        }
    }

    public function workerOrders()
    {
        $user = auth()->user();
        if ($user->role !== 'worker') {
            abort(403);
        }

        $orders = Order::with(['client', 'tasks', 'assignedWorker'])
            ->where('assigned_to', $user->id)
            ->latest()
            ->paginate(10);

        return view('pages.worker.orders.index', compact('orders'))
            ->with(['title' => 'My Orders List']);
    }

    public function workerOrderShow($id)
    {
        $user = auth()->user();
        if ($user->role !== 'worker') {
            abort(403, 'Unauthorized');
        }

        $order = Order::with(['client', 'tasks', 'assignedWorker', 'service'])
            ->where('assigned_to', $user->id)
            ->findOrFail($id);

        return view('pages.worker.orders.detail', compact('order'))
            ->with(['title' => 'Order Details']);
    }

    public function track(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::with(['client', 'tasks', 'assignedWorker'])->where('id', $request->order_id)->first();

        return view('pages.orders.track', compact('order'));
    }

    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Unauthorized');
            }

            // Hapus semua file attachment dari Order
            if ($order->attachment) {
                foreach ($order->attachment as $path) {
                    Storage::disk('public')->delete($path);
                }
            }

            // Task akan dihapus otomatis via cascade
            $order->delete();

            Log::info("Order {$id} deleted, related tasks deleted via cascade.");

            return response()->json(['message' => 'Order and related tasks deleted successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Failed to delete order: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Failed to delete order: ' . $e->getMessage()], 500);
        }
    }

    public function detail($id)
    {
        $order = Order::with(['client', 'service', 'tasks'])->findOrFail($id);
        return view('pages.admin.orders.detail', compact('order'))->with(['title' => 'Order Detail']);
    }
}

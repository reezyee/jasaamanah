<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $tasks = Task::with(['assignedUser', 'order.client'])->latest()->paginate(10);
            $view = 'pages.admin.tasks';
            $title = 'Task Management (Admin)';
        } else {
            $tasks = Task::with(['assignedUser', 'order.client'])
                ->where('assigned_to', $user->id)
                ->latest()
                ->paginate(10);
            $view = 'pages.worker.tasks';
            $title = 'My Assigned Tasks';
        }

        $users = User::where('role', 'worker')->get();
        $clients = User::where('role', 'client')->with('orders')->get();

        return view($view, compact('tasks', 'users', 'clients', 'title'));
    }

    public function show($id)
    {
        $task = Task::with(['assignedUser', 'order.client'])->findOrFail($id);
        return response()->json($task);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'division' => 'required|in:legalitas,design,website',
            'status' => 'required|in:Drafting,Review,Finalizing,Concepting,Designing,Revising,Planning,Developing,Testing,Deployment',
            'assigned_to' => 'required|exists:users,id',
            'order_id' => 'required|exists:orders,id',
            'file_attachment.*' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048', // Multiple files
            'note' => 'nullable|string',
        ]);

        $attachmentPaths = [];
        if ($request->hasFile('file_attachment')) {
            foreach ($request->file('file_attachment') as $file) {
                $attachmentPaths[] = $file->store('tasks', 'public');
            }
        }

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'division' => $request->division,
            'status' => $request->status,
            'assigned_to' => $request->assigned_to,
            'order_id' => $request->order_id,
            'file_attachment' => $attachmentPaths,
            'note' => $request->note,
        ]);

        return response()->json(['message' => 'Task created successfully.', 'task' => $task->load('assignedUser', 'order.client')], 201);
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        if (auth()->user()->role !== 'admin' && auth()->id() !== $task->assigned_to) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'division' => 'required|in:legalitas,design,website',
            'status' => 'required|in:Drafting,Review,Finalizing,Concepting,Designing,Revising,Planning,Developing,Testing,Deployment',
            'assigned_to' => 'required|exists:users,id',
            'order_id' => 'required|exists:orders,id',
            'file_attachment.*' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048',
            'note' => 'nullable|string',
        ]);

        $attachmentPaths = $task->file_attachment ?? [];
        if ($request->hasFile('file_attachment')) {
            // Hapus file lama jika ada
            foreach ($attachmentPaths as $path) {
                Storage::disk('public')->delete($path);
            }
            $attachmentPaths = [];
            foreach ($request->file('file_attachment') as $file) {
                $attachmentPaths[] = $file->store('tasks', 'public');
            }
        }

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'division' => $request->division,
            'status' => $request->status,
            'assigned_to' => $request->assigned_to,
            'order_id' => $request->order_id,
            'file_attachment' => $attachmentPaths,
            'note' => $request->note,
        ]);

        // Sinkronisasi ke Order
        $order = $task->order;
        if ($order) {
            $order->update([
                'division' => $request->division,
                'progress_status' => $request->status,
                'assigned_to' => $request->assigned_to,
                'attachment' => $attachmentPaths,
                'admin_notes' => $request->note,
            ]);
        }

        return response()->json(['message' => 'Task updated successfully.', 'task' => $task->load('assignedUser', 'order.client')], 200);
    }

    public function updateStatus(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);

        // Cek otorisasi
        if (auth()->user()->role !== 'admin' && auth()->id() !== $task->assigned_to) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Daftar status yang valid berdasarkan divisi
        $validStatuses = [
            'legalitas' => ['Drafting', 'Review', 'Finalizing'],
            'design' => ['Concepting', 'Designing', 'Revising', 'Finalizing'],
            'website' => ['Planning', 'Developing', 'Testing', 'Deployment'],
        ];

        // Validasi request
        $request->validate([
            'status' => [
                'required',
                function ($attribute, $value, $fail) use ($task, $validStatuses) {
                    if (!in_array($value, $validStatuses[$task->division])) {
                        $fail("The selected status is invalid for the {$task->division} division.");
                    }
                },
            ],
            'file_attachment.*' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048', // Validasi file
            'note' => 'nullable|string',
        ]);

        // Proses file attachment
        $attachmentPaths = $task->file_attachment ?? [];
        if ($request->hasFile('file_attachment')) {
            // Tambahkan file baru tanpa menghapus file lama (append)
            foreach ($request->file('file_attachment') as $file) {
                $attachmentPaths[] = $file->store('tasks', 'public');
            }
        }

        // Update task dengan status, file attachment, dan note
        $task->update([
            'status' => $request->status,
            'file_attachment' => $attachmentPaths,
            'note' => $request->note,
        ]);

        // Sinkronisasi ke Order
        $order = $task->order;
        if ($order) {
            $progressStatus = $this->mapTaskStatusToOrderStatus($request->status, $task->division);

            // Update progress_status, status, attachment, dan admin_notes di order
            $order->update([
                'progress_status' => $request->status, // Simpan status task langsung sebagai progress_status
                'status' => $progressStatus, // Status order berdasarkan pemetaan
                'attachment' => $attachmentPaths, // Update attachment di order
                'admin_notes' => $request->note, // Update note di order
            ]);

            // Jika semua task selesai, ubah status order menjadi "Selesai"
            $finalStatus = end($validStatuses[$task->division]);
            if ($request->status === $finalStatus && $order->tasks()->where('status', '!=', $finalStatus)->count() === 0) {
                $order->update(['status' => 'Selesai']);
            }
        }

        return response()->json([
            'message' => 'Task status updated successfully.',
            'task' => $task->load('assignedUser', 'order.client'),
            'order_status' => $order ? $order->status : null,
        ], 200);
    }

    /**
     * Delete a specific file attachment from a task
     */
    public function deleteAttachment($taskId, $fileIndex)
    {
        $task = Task::findOrFail($taskId);

        // Cek otorisasi
        if (auth()->user()->role !== 'admin' && auth()->id() !== $task->assigned_to) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Ambil daftar file attachment
        $attachmentPaths = $task->file_attachment ?? [];

        // Validasi indeks file
        if (!isset($attachmentPaths[$fileIndex])) {
            return response()->json(['message' => 'File not found'], 404);
        }

        // Ambil path file yang akan dihapus
        $fileToDelete = $attachmentPaths[$fileIndex];

        // Hapus file dari storage
        Storage::disk('public')->delete($fileToDelete);

        // Hapus file dari array
        unset($attachmentPaths[$fileIndex]);

        // Reindex array untuk menghindari gap pada indeks
        $attachmentPaths = array_values($attachmentPaths);

        // Update task dengan daftar file yang baru
        $task->update([
            'file_attachment' => $attachmentPaths,
        ]);

        // Sinkronisasi ke Order
        $order = $task->order;
        if ($order) {
            $order->update([
                'attachment' => $attachmentPaths, // Update attachment di order
            ]);
        }

        return response()->json(['message' => 'File deleted successfully'], 200);
    }

    /**
     * Map status task ke status order
     */
    private function mapTaskStatusToOrderStatus($taskStatus, $division)
    {
        $finalStatuses = [
            'legalitas' => 'Finalizing',
            'design' => 'Finalizing',
            'website' => 'Deployment',
        ];

        $middleStatuses = [
            'legalitas' => ['Review'],
            'design' => ['Designing', 'Revising'],
            'website' => ['Developing', 'Testing'],
        ];

        $initialStatuses = [
            'legalitas' => ['Drafting'],
            'design' => ['Concepting'],
            'website' => ['Planning'],
        ];

        if ($taskStatus === $finalStatuses[$division]) {
            return 'Completed';
        } elseif (in_array($taskStatus, $middleStatuses[$division])) {
            return 'Processing';
        } elseif (in_array($taskStatus, $initialStatuses[$division])) {
            return 'Pending';
        } else {
            return $order->status ?? 'Pending'; // Default ke status saat ini jika tidak cocok
        }
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        if (auth()->user()->role !== 'admin' && auth()->id() !== $task->assigned_to) {
            abort(403, 'Unauthorized');
        }

        $order = $task->order;

        // Cek apakah file attachment digunakan oleh Order
        $taskAttachments = $task->file_attachment ?? [];
        $orderAttachments = $order ? ($order->attachment ?? []) : [];

        // Hapus file dari storage hanya jika tidak digunakan oleh Order
        if (!empty($taskAttachments)) {
            foreach ($taskAttachments as $path) {
                if (!in_array($path, $orderAttachments)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }

        $task->delete();

        // Periksa apakah ini Task terakhir dari Order
        if ($order && $order->tasks()->count() === 0) {
            return response()->json([
                'message' => 'Task deleted successfully. This was the last task for the order.',
                'last_task' => true,
                'order_id' => $order->id,
            ], 200);
        }

        return response()->json(['message' => 'Task deleted successfully.'], 200);
    }
}
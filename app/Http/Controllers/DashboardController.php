<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // [Admin logic remains unchanged]
            $totalUsers = User::count();
            $totalRevenue = Order::where('status', 'completed')
                ->join('services', 'orders.service_id', '=', 'services.id')
                ->sum('services.price');
            $totalOrders = Order::count();
            $completedOrders = Order::where('status', 'completed')->count();
            $conversionRate = $totalOrders > 0 ? ($completedOrders / $totalOrders) * 100 : 0;
            $activeOrders = Order::whereIn('status', ['pending', 'in_progress'])->count();
            $recentActivities = Order::with('client', 'tasks')
                ->latest()
                ->take(4)
                ->get();
            $salesData = Order::where('status', 'completed')
                ->selectRaw('MONTH(order_date) as month, SUM(services.price) as total')
                ->join('services', 'orders.service_id', '=', 'services.id')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month');
            $recentOrders = Order::with('client', 'assignedWorker', 'service')
                ->latest()
                ->take(5)
                ->get();

            return view('pages.admin.index', [
                'title' => 'Admin Dashboard',
                'totalUsers' => $totalUsers,
                'totalRevenue' => $totalRevenue,
                'conversionRate' => $conversionRate,
                'activeOrders' => $activeOrders,
                'recentActivities' => $recentActivities,
                'salesData' => $salesData,
                'recentOrders' => $recentOrders,
            ]);
        } elseif ($user->role === 'worker') {
            // Worker-specific data
            $worker = $user;

            // Total Orders Assigned to Worker
            $totalOrders = Order::where('assigned_to', $worker->id)->count();

            // Total Revenue from Completed Orders
            $totalRevenue = Order::where('assigned_to', $worker->id)
                ->where('status', 'completed')
                ->join('services', 'orders.service_id', '=', 'services.id')
                ->sum('services.price');

            // Task Completion Rate
            $totalTasks = Task::where('assigned_to', $worker->id)->count();
            $completedTasks = Task::where('assigned_to', $worker->id)
                ->where('status', 'completed')
                ->count();
            $completionRate = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

            // Active Tasks
            $activeTasks = Task::where('assigned_to', $worker->id)
                ->whereIn('status', ['pending', 'in_progress'])
                ->count();

            // Recent Activities (Tasks assigned to worker)
            $recentActivities = Task::where('assigned_to', $worker->id)
                ->with('order', 'order.client')
                ->latest()
                ->take(4)
                ->get();

            // Sales Data (Monthly revenue from worker's completed orders)
            $salesData = Order::where('assigned_to', $worker->id)
                ->where('status', 'completed')
                ->selectRaw('MONTH(order_date) as month, SUM(services.price) as total')
                ->join('services', 'orders.service_id', '=', 'services.id')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month');

            // Recent Orders Assigned to Worker
            $recentOrders = Order::where('assigned_to', $worker->id)
                ->with('client', 'service')
                ->latest()
                ->take(5)
                ->get();

            return view('pages.worker.index', [
                'title' => 'Worker Dashboard',
                'totalOrders' => $totalOrders,
                'totalRevenue' => $totalRevenue,
                'completionRate' => $completionRate,
                'activeTasks' => $activeTasks,
                'recentActivities' => $recentActivities,
                'salesData' => $salesData,
                'recentOrders' => $recentOrders,
            ]);
        } else {
            return view('dashboard.client', ['title' => 'Client Dashboard']);
        }
    }
}
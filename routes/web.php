<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Auth::routes();

// Public Routes
Route::get('/', function () {
    return view('pages.index', ['title' => 'Home']);
})->name('home');
Route::get('/services', [ServiceController::class, 'publicIndex'])->name('services');
Route::get('/about', [ContactController::class, 'index'])->name('about');
Route::post('/about/send', [ContactController::class, 'sendEmail'])->name('contact.send');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Client Routes (No Authentication Required)
Route::get('/track-order', [OrderController::class, 'track'])->name('order.track');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard untuk semua role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Help Page
    Route::get('/help', function () {
        return view('pages.help', ['title' => 'Help']);
    })->name('help');

    // Settings Routes (untuk admin)
    Route::prefix('admin/settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('/profile', [SettingController::class, 'updateProfile'])->name('updateProfile');
        Route::put('/password', [SettingController::class, 'updatePassword'])->name('updatePassword');
        Route::put('/website', [SettingController::class, 'updateWebsiteSettings'])->name('updateWebsite');
    });

    // Settings Routes untuk Client (User)
    Route::prefix('user/settings')->name('user.settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('/profile', [SettingController::class, 'updateProfile'])->name('updateProfile');
        Route::put('/password', [SettingController::class, 'updatePassword'])->name('updatePassword');
    });
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Orders Management
    Route::prefix('admin/orders')->name('admin.orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/{id}', [OrderController::class, 'show'])->name('show');
        Route::put('/{id}', [OrderController::class, 'update'])->name('update');
        Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/detail', [OrderController::class, 'detail'])->name('detail');
    });

    // Workers Management
    Route::prefix('admin/workers')->name('admin.workers.')->group(function () {
        Route::get('/', [WorkerController::class, 'index'])->name('index');
        Route::post('/', [WorkerController::class, 'store'])->name('store');
    });

    // Users Management
    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Services Management
    Route::prefix('admin/services')->name('admin.services.')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('index');
        Route::post('/', [ServiceController::class, 'store'])->name('store');
        Route::get('/{id}', [ServiceController::class, 'show'])->name('show');
        Route::put('/{id}', [ServiceController::class, 'update'])->name('update');
        Route::delete('/{id}', [ServiceController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [ServiceController::class, 'bulkDestroy'])->name('bulk-destroy');
    });

    // Tasks Management
    Route::prefix('admin/tasks')->name('admin.tasks.')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/{id}', [TaskController::class, 'show'])->name('show');
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::put('/{id}', [TaskController::class, 'update'])->name('update');
        Route::patch('/{task}/status', [TaskController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{id}', [TaskController::class, 'destroy'])->name('destroy');
        Route::delete('/{task}/delete-attachment/{fileIndex}', [TaskController::class, 'deleteAttachment'])->name('deleteAttachment');
    });
});

// Worker Routes
Route::middleware(['auth', 'role:worker'])->group(function () {
    // Dashboard untuk Worker
    Route::get('/worker', [DashboardController::class, 'index'])->name('worker.dashboard');

    // Settings untuk Worker
    Route::prefix('worker/settings')->name('worker.settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('/profile', [SettingController::class, 'updateProfile'])->name('updateProfile');
        Route::put('/password', [SettingController::class, 'updatePassword'])->name('updatePassword');
    });

    // Orders Management
    Route::prefix('worker/orders')->name('worker.orders.')->group(function () {
        Route::get('/', [OrderController::class, 'workerOrders'])->name('index');
        Route::get('/{id}', [OrderController::class, 'workerOrderShow'])->name('show');
    });

    // Tasks Management
    Route::prefix('worker/tasks')->name('worker.tasks.')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::get('/{id}', [TaskController::class, 'show'])->name('show');
        Route::patch('/{task}/status', [TaskController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{task}/delete-attachment/{fileIndex}', [TaskController::class, 'deleteAttachment'])->name('deleteAttachment');
    });
});

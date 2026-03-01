<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

// register the role middleware alias so we can use it on routes
Route::aliasMiddleware('role', RoleMiddleware::class);

// public welcome page
Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    }

    return view('welcome');
});

// authentication routes
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

if (config('auth.registration_enabled')) {
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
}

// forgot/reset password and admin reset links are behind a toggle
if (config('auth.password_reset_enabled')) {
    Route::get('forgot-password', [AuthController::class, 'showForgotPassword'])
        ->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'sendForgotPasswordLink'])
        ->name('password.email');
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPassword'])
        ->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])
        ->name('password.update');
}

// admin area protected by auth and only accessible to admins
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('items', ItemController::class);
    Route::resource('transactions', TransactionController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('users', \App\Http\Controllers\UserController::class);
    // quick toggle endpoint for active/disabled state
    Route::patch('users/{user}/toggle', [\App\Http\Controllers\UserController::class, 'toggle'])->name('users.toggle');

    // admin-triggered password reset (only if resets are enabled)
    if (config('auth.password_reset_enabled')) {
        Route::patch('users/{user}/reset-password', [\App\Http\Controllers\UserController::class, 'resetPassword'])
            ->name('users.resetPassword');
    }
});

// shared settings accessible to any authenticated user
Route::middleware('auth')->group(function () {
    Route::get('settings', [AuthController::class, 'settings'])->name('settings');
    Route::post('settings', [AuthController::class, 'updateSettings'])->name('settings.update');
    Route::post('settings/password', [AuthController::class, 'updatePassword'])->name('settings.password');

    // basic notification system (design complete, implementation stub)
    Route::get('notifications', [\App\Http\Controllers\NotificationController::class, 'index'])
        ->name('notifications.index');
    Route::patch('notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])
        ->name('notifications.mark');
    Route::patch('notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllRead'])
        ->name('notifications.markAllRead');
    Route::patch('mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllRead'])
        ->name('notifications.markAllRead');
});

// user area (basic dashboard) protected by auth and role user
Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

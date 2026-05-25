<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

// Redirect welcome page to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Dashboard (accessible only by admin)
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::get('/admin/export-csv', [AdminController::class, 'exportCsv'])->name('admin.users.export-csv');
        Route::post('/admin/storage-link', [AdminController::class, 'storageLink'])->name('admin.storage-link');
        Route::post('/admin/clear-cache', [AdminController::class, 'clearCache'])->name('admin.clear-cache');
        Route::post('/admin/migrate', [AdminController::class, 'runMigration'])->name('admin.migrate');
    });

    // Member Dashboard (accessible only by member)
    Route::middleware('role:member')->group(function () {
        Route::get('/member', [MemberController::class, 'index'])->name('member.dashboard');
    });
});

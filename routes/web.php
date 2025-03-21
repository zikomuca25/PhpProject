<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EmployeeController;


// Default Page - Redirect to Login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route(Auth::user()->role === 'Administrator' ? 'admin.dashboard' : 'employee.dashboard');
    }
    return redirect()->route('login'); 
});
//logout
Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

//Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot.password');
Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('reset.password');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/call-back', [AuthController::class, 'handleGoogleCallback']);

Route::post('/login', [AuthController::class, 'login'])->name('process.login');
Route::post('/register', [AuthController::class, 'register'])->name('process.register');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('process.forgot.password');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return ($user->role === 'Administrator') 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('employee.dashboard');
    })->name('dashboard');

    // Admin dashboard login
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });

    // Employee dashboard login
    Route::middleware(['employee'])->group(function () {
        Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
    });
});


Route::get('/admin/get-departments-tree', [AdminController::class, 'getDepartmentsTree'])->name('admin.getDepartmentsTree');
Route::get('/admin/get-employees', [AdminController::class, 'getEmployees'])->name('admin.getEmployees');
Route::post('/admin/update-employee/{id}', [AdminController::class, 'updateEmployee'])->name('admin.updateEmployee');
Route::delete('/admin/delete-employee/{id}', [AdminController::class, 'deleteEmployee'])->name('admin.deleteEmployee');
//Route::get('/admin/get-departments-dropdown', [AdminController::class, 'getDepartmentsDropdown'])->name('admin.getDepartmentsDropdown');

use App\Http\Controllers\CommonController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [CommonController::class, 'index'])->name('dashboard');
});

use App\Http\Controllers\ChatController;

Route::middleware('auth')->group(function () {
    Route::get('/admin/get-messages', [ChatController::class, 'getMessages'])->name('chat.getMessages');
    Route::post('/admin/send-message', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');
});
use App\Models\User;

Route::get('/admin/get-users', [ChatController::class, 'getUsers'])->name('chat.getUsers');
Route::post('/admin/mark-messages-read', [ChatController::class, 'markMessagesRead'])->name('chat.markMessagesRead');
use App\Http\Controllers\ProfileController;

Route::get('/profile', [ProfileController::class, 'showProfile'])->middleware('auth');
use App\Http\Controllers\DepartmentController;

Route::get('/admin/get-departments', [DepartmentController::class, 'getDepartments']);
Route::post('/admin/add-department', [DepartmentController::class, 'store']);


/*Route::post('/admin/add-employee', [EmployeeController::class, 'store']);
Route::get('/admin/get-employee/{id}', [EmployeeController::class, 'edit'])
    ->name('admin.getEmployee');*/

    Route::post('/admin/add-employee', [AdminController::class, 'addEmployee']);
    Route::get('/admin/get-employee/{id}', [AdminController::class, 'edit'])->name('admin.getEmployee');


    // Update Profile Route
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
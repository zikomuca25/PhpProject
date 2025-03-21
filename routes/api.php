<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

// ✅ API Routes for Employee Features
Route::get('/employee-directory', [EmployeeController::class, 'getDirectory']);
Route::get('/employee-profile', [EmployeeController::class, 'getProfile']);
Route::get('/announcements', [EmployeeController::class, 'getAnnouncements']);
Route::get('/tasks', [EmployeeController::class, 'getTasks']);

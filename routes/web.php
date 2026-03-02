<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


Route::get('/home', [AuthCOntroller::class, 'home']);

Route::middleware(['guest.custom'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/admin/accounts', [AdminController::class, 'accounts']);
    Route::get('/admin/products', [AdminController::class, 'products']);
    Route::get('/admin/orders', [AdminController::class, 'orders']);
    Route::get('/admin/returns', [AdminController::class, 'returns']);
    Route::get('/admin/reviews', [AdminController::class, 'reviews']);
    Route::get('/admin/employees', [AdminController::class, 'employees']);
    Route::get('/admin/positions', [AdminController::class, 'positions']);
    Route::get('/admin/expenses', [AdminController::class, 'expenses']);
    Route::get('/admin/categories', [AdminController::class, 'categories']);
    Route::get('/admin/reports', [AdminController::class, 'reports']);
});

Route::get('/logout', [AuthController::class, 'logout']);
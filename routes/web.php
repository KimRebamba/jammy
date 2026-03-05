<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerHomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::get('/home', [AuthCOntroller::class, 'home']);

Route::middleware(['guest.custom'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['customer'])->group(function(){
    Route::get('/customer/index', [CustomerHomeController::class, 'index']);

    Route::get('/customer/profile', [ProfileController::class, 'show']);
    Route::get('/customer/profile/edit', [ProfileController::class, 'edit']);

    Route::get('/shop', [ProductController::class, 'categories']);
    Route::get('/shop/categories/{category}', [ProductController::class, 'brandsForCategory']);
    Route::get('/shop/categories/{category}/brands/{brand}', [ProductController::class, 'productsForBrandAndCategory']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);

    Route::get('/reviews', [ReviewController::class, 'index']);

    Route::get('/cart', [CartController::class, 'index']);
});

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

    Route::get('/admin/accounts', [AdminController::class, 'accounts']);
    Route::get('/admin/accounts/create', [AdminController::class, 'accountsCreate']);
    Route::post('/admin/accounts', [AdminController::class, 'accountsStore']);
    Route::get('/admin/accounts/{id}', [AdminController::class, 'accountsShow']);
    Route::get('/admin/accounts/{id}/edit', [AdminController::class, 'accountsEdit']);
    Route::post('/admin/accounts/{id}/update', [AdminController::class, 'accountsUpdate']);
    Route::post('/admin/accounts/{id}/delete', [AdminController::class, 'accountsDelete']);

    Route::get('/admin/products', [AdminController::class, 'products']);
    Route::get('/admin/products/create', [AdminController::class, 'productsCreate']);
    Route::post('/admin/products', [AdminController::class, 'productsStore']);
    Route::get('/admin/products/{id}', [AdminController::class, 'productsShow']);
    Route::get('/admin/products/{id}/edit', [AdminController::class, 'productsEdit']);
    Route::post('/admin/products/{id}/update', [AdminController::class, 'productsUpdate']);
    Route::post('/admin/products/{id}/delete', [AdminController::class, 'productsDelete']);

    Route::get('/admin/orders', [AdminController::class, 'orders']);
    Route::get('/admin/orders/{id}', [AdminController::class, 'ordersShow']);
    Route::get('/admin/orders/{id}/edit', [AdminController::class, 'ordersEdit']);
    Route::post('/admin/orders/{id}/update', [AdminController::class, 'ordersUpdate']);
    Route::post('/admin/orders/{id}/delete', [AdminController::class, 'ordersDelete']);

    Route::get('/admin/returns', [AdminController::class, 'returns']);
    Route::get('/admin/returns/{id}', [AdminController::class, 'returnsShow']);
    Route::get('/admin/returns/{id}/edit', [AdminController::class, 'returnsEdit']);
    Route::post('/admin/returns/{id}/update', [AdminController::class, 'returnsUpdate']);
    Route::post('/admin/returns/{id}/delete', [AdminController::class, 'returnsDelete']);

    Route::get('/admin/reviews', [AdminController::class, 'reviews']);
    Route::get('/admin/reviews/{id}', [AdminController::class, 'reviewsShow']);
    Route::get('/admin/reviews/{id}/edit', [AdminController::class, 'reviewsEdit']);
    Route::post('/admin/reviews/{id}/update', [AdminController::class, 'reviewsUpdate']);
    Route::post('/admin/reviews/{id}/delete', [AdminController::class, 'reviewsDelete']);

    Route::get('/admin/employees', [AdminController::class, 'employees']);
    Route::get('/admin/employees/create', [AdminController::class, 'employeesCreate']);
    Route::post('/admin/employees', [AdminController::class, 'employeesStore']);
    Route::get('/admin/employees/{id}', [AdminController::class, 'employeesShow']);
    Route::get('/admin/employees/{id}/edit', [AdminController::class, 'employeesEdit']);
    Route::post('/admin/employees/{id}/update', [AdminController::class, 'employeesUpdate']);
    Route::post('/admin/employees/{id}/delete', [AdminController::class, 'employeesDelete']);

    Route::get('/admin/positions', [AdminController::class, 'positions']);
    Route::get('/admin/positions/create', [AdminController::class, 'positionsCreate']);
    Route::post('/admin/positions', [AdminController::class, 'positionsStore']);
    Route::get('/admin/positions/{id}', [AdminController::class, 'positionsShow']);
    Route::get('/admin/positions/{id}/edit', [AdminController::class, 'positionsEdit']);
    Route::post('/admin/positions/{id}/update', [AdminController::class, 'positionsUpdate']);
    Route::post('/admin/positions/{id}/delete', [AdminController::class, 'positionsDelete']);

    Route::get('/admin/expenses', [AdminController::class, 'expenses']);
    Route::get('/admin/expenses/create', [AdminController::class, 'expensesCreate']);
    Route::post('/admin/expenses', [AdminController::class, 'expensesStore']);
    Route::get('/admin/expenses/{id}', [AdminController::class, 'expensesShow']);
    Route::get('/admin/expenses/{id}/edit', [AdminController::class, 'expensesEdit']);
    Route::post('/admin/expenses/{id}/update', [AdminController::class, 'expensesUpdate']);
    Route::post('/admin/expenses/{id}/delete', [AdminController::class, 'expensesDelete']);

    Route::get('/admin/categories', [AdminController::class, 'categories']);
    Route::get('/admin/categories/create', [AdminController::class, 'categoriesCreate']);
    Route::post('/admin/categories', [AdminController::class, 'categoriesStore']);
    Route::get('/admin/categories/{id}', [AdminController::class, 'categoriesShow']);
    Route::get('/admin/categories/{id}/edit', [AdminController::class, 'categoriesEdit']);
    Route::post('/admin/categories/{id}/update', [AdminController::class, 'categoriesUpdate']);
    Route::post('/admin/categories/{id}/delete', [AdminController::class, 'categoriesDelete']);

    Route::get('/admin/salaries', [AdminController::class, 'salaries']);
    Route::get('/admin/salaries/create', [AdminController::class, 'salariesCreate']);
    Route::post('/admin/salaries', [AdminController::class, 'salariesStore']);
    Route::get('/admin/salaries/{id}', [AdminController::class, 'salariesShow']);
    Route::get('/admin/salaries/{id}/edit', [AdminController::class, 'salariesEdit']);
    Route::post('/admin/salaries/{id}/update', [AdminController::class, 'salariesUpdate']);
    Route::post('/admin/salaries/{id}/delete', [AdminController::class, 'salariesDelete']);

    Route::get('/admin/brands', [AdminController::class, 'brands']);
    Route::get('/admin/brands/create', [AdminController::class, 'brandsCreate']);
    Route::post('/admin/brands', [AdminController::class, 'brandsStore']);
    Route::get('/admin/brands/{id}', [AdminController::class, 'brandsShow']);
    Route::get('/admin/brands/{id}/edit', [AdminController::class, 'brandsEdit']);
    Route::post('/admin/brands/{id}/update', [AdminController::class, 'brandsUpdate']);
    Route::post('/admin/brands/{id}/delete', [AdminController::class, 'brandsDelete']);

    Route::get('/admin/reports', [AdminController::class, 'reports']);
});

Route::get('/logout', [AuthController::class, 'logout']);
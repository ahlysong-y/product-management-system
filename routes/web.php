<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockHistoryController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return redirect('/dashboard');
});

// Authentication Routes
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Public Routes
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/logs', [ActivityLogController::class, 'index'])
        ->name('logs.index');

    Route::get('/stocks', [StockHistoryController::class, 'index'])
        ->name('stocks.index');
});

// Report Routes
Route::get('/products/pdf', [ReportController::class, 'pdf'])
    ->name('products.pdf');

Route::get('/products/print', [ReportController::class, 'print'])
    ->name('products.print');

Route::get('/products/excel', [ReportController::class, 'excel'])
    ->name('products.excel');

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {

    Route::resource('products', ProductController::class);

    Route::resource('categories', CategoryController::class);

    Route::resource('sales', SaleController::class);

    Route::resource('suppliers', SupplierController::class);
});

Route::get('/run-migration', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return "Database migration បានជោគជ័យហើយ!";
    } catch (\Exception $e) {
        return "មានបញ្ហា៖ " . $e->getMessage();
    }
});

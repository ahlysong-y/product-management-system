<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockHistoryController;
use App\Http\Controllers\SupplierController;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Home Route
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (ទាមទារ Login មុននឹងចូលប្រើ)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');
    Route::get('/stocks', [StockHistoryController::class, 'index'])->name('stocks.index');

    /* --- ផ្នែកគ្រប់គ្រងផលិតផល (Product Management) --- */
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // បានបន្ថែម និងកែតម្រូវនៅត្រង់នេះ ដើម្បីដោះស្រាយកំហុស Route NotFound
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

    /* --- ផ្នែករបាយការណ៍ (Reports) --- */
    Route::get('/products/pdf', [ReportController::class, 'pdf'])->name('products.pdf');
    Route::get('/products/print', [ReportController::class, 'print'])->name('products.print');
    Route::get('/products/excel', [ReportController::class, 'excel'])->name('products.excel');

    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    /* --- Resource Routes ផ្សេងៗ --- */
    Route::resource('categories', CategoryController::class);
    Route::resource('sales', SaleController::class);
    Route::resource('suppliers', SupplierController::class);
});

/*
|--------------------------------------------------------------------------
| Development Routes (សម្រាប់តែការអភិវឌ្ឍន៍)
|--------------------------------------------------------------------------
*/
Route::get('/run-migration', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return 'Database migration success!';
    } catch (Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/create-admin', function () {
    $user = User::where('email', 'admin@gmail.com')->first();

    if (!$user) {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        return 'Admin account created successfully!';
    }

    $user->update([
        'role' => 'admin'
    ]);

    return 'Admin role updated successfully!';
});

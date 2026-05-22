<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockHistoryController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
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

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/logs', [ActivityLogController::class, 'index'])
        ->name('logs.index');

    Route::get('/stocks', [StockHistoryController::class, 'index'])
        ->name('stocks.index');

    // Allow all authenticated users to view products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
});

/*
|--------------------------------------------------------------------------
| Report Routes
|--------------------------------------------------------------------------
*/

Route::get('/products/pdf', [ReportController::class, 'pdf'])
    ->name('products.pdf');

Route::get('/products/print', [ReportController::class, 'print'])
    ->name('products.print');

Route::get('/products/excel', [ReportController::class, 'excel'])
    ->name('products.excel');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    // Admin-only: create, edit, delete for products
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::resource('categories', CategoryController::class);

    Route::resource('sales', SaleController::class);

    Route::resource('suppliers', SupplierController::class);
});

/*
|--------------------------------------------------------------------------
| Development Routes (Remove in Production)
|--------------------------------------------------------------------------
*/

Route::get('/run-migration', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return "Database migration success!";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

Route::get('/create-admin', function () {
    // ស្វែងរកមើលថាតើមានគណនី admin@gmail.com នេះហើយឬនៅ
    $user = User::where('email', 'admin@gmail.com')->first();

    if (!$user) {
        // បើមិនទាន់មានទេ គឺបង្កើតគណនីថ្មី រួចដាក់ role ទៅជា admin ភ្លាមៗ
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        return "បង្កើតគណនី និងផ្តល់សិទ្ធិជា Admin ជោគជ័យហើយ! សូមទៅសាកល្បង Login ឡើងវិញ។";
    }

    // បើមានគណនីនេះរួចហើយ វានឹងធ្វើការ Update role ឱ្យទៅជា admin ភ្លាម
    $user->update(['role' => 'admin']);
    return "គណនីមានរួចហើយ! ប៉ុន្តែបានធ្វើបច្ចុប្បន្នភាពកែប្រែសិទ្ធិ Role ទៅជា Admin ជោគជ័យហើយ!";
});

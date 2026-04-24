<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DiscountsPromosController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\LowStockAlertsController;
use App\Http\Controllers\PurchaseOrdersController;
use App\Http\Controllers\ReturnsRefundsController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\TransactionDetailsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserRolesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\InventoryLogsController;

// Corrected Imports: Remove the "Auth" sub-folder
use App\Http\Controllers\LoginController; 
use App\Http\Controllers\RegisterController;
// ... (keep your other controller imports as they are)

// 1. GUEST ROUTES (Put these at the top)
Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// 2. PROTECTED ROUTES (Keep your existing role-based logic here)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('products', ProductsController::class);
    Route::resource('categories', CategoriesController::class);
    // ... rest of your resources
});

// Routes that require NO specific role, just authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Admin ONLY Routes (Administration Module)
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('users', UsersController::class);
    Route::resource('roles', UserRolesController::class);
    Route::resource('logs', LogsController::class);
});

// Manager & Admin Routes (Inventory & Supply Chain Modules)
// Route::middleware(['auth', 'role:Admin,Manager'])->group(function () {
    Route::resource('products', ProductsController::class);
    Route::resource('categories', CategoriesController::class);
    Route::resource('suppliers', SuppliersController::class);
    Route::resource('purchase_orders', PurchaseOrdersController::class);
    Route::resource('inventory_logs', InventoryLogsController::class);
    Route::resource('low_stock_alerts', LowStockAlertsController::class);
//});

// Cashier, Manager, & Admin Routes (Sales Module)
Route::middleware(['auth', 'role:Admin,Manager,Cashier'])->group(function () {
    Route::resource('transactions', TransactionsController::class);
    Route::resource('transaction_details', TransactionDetailsController::class);
    Route::resource('returns_refunds', ReturnsRefundsController::class);
    Route::resource('promos', DiscountsPromosController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
});
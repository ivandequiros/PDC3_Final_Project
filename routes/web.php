<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserRolesController; // Using this consistently
use App\Http\Controllers\LogsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\PurchaseOrdersController;
use App\Http\Controllers\InventoryLogsController;
use App\Http\Controllers\LowStockAlertsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\TransactionDetailsController;
use App\Http\Controllers\ReturnsRefundsController;
use App\Http\Controllers\DiscountsPromosController;
use App\Http\Controllers\DashboardController;

// 1. Guest Routes (Login / Register)
Route::middleware(['guest'])->group(function () {
    Route::get('/', fn() => redirect()->route('login'));
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// 2. Authenticated Routes
Route::middleware(['auth'])->group(function () {
    
    // Universal Actions
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // --- ADMIN ONLY ---
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('users', UsersController::class);
        
        // This handles index, create, store, edit, update, AND destroy automatically
        Route::resource('roles', UserRolesController::class); 
    });

    // --- ADMIN & MANAGER (Inventory & Supply Chain) ---
    Route::middleware(['role:Admin,Manager'])->group(function () {
        Route::resource('products', ProductsController::class);
        Route::resource('categories', CategoriesController::class);
        Route::resource('suppliers', SuppliersController::class);
        Route::resource('purchase_orders', PurchaseOrdersController::class);
        Route::resource('inventory_logs', InventoryLogsController::class);
        Route::resource('low_stock_alerts', LowStockAlertsController::class);
        Route::resource('logs', LogsController::class);
    });

    // --- ADMIN & CASHIER (Sales Operations) ---
    Route::middleware(['role:Admin,Cashier'])->group(function () {
        Route::get('/pos', [TransactionsController::class, 'create'])->name('pos.index');
        Route::post('/checkout', [TransactionsController::class, 'store'])->name('pos.checkout');
    });

    // --- ALL STAFF (Records & History) ---
    Route::middleware(['role:Admin,Manager,Cashier'])->group(function () {
        // We exclude create/store here because they are handled in the POS block above
        Route::resource('transactions', TransactionsController::class)->except(['create', 'store']);
        Route::resource('transaction_details', TransactionDetailsController::class);
        Route::resource('returns_refunds', ReturnsRefundsController::class);
        Route::resource('promos', DiscountsPromosController::class);
    });
});
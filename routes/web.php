<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaxAndDiscountController;
use App\Http\Controllers\PosController;

Route::get('/', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::middleware(['auth'])->group(function () {
    Route::delete('/logout', [AuthController::class, 'destroy'])->name('logout');
    Route::resource('dashboard', DashboardController::class)->only(['index']);
    Route::get('/change-password', [AuthController::class, 'index'])->name('change.password');
    Route::patch('/change-password', [AuthController::class, 'update'])->name('update.password');
    Route::resource('categories', CategoryController::class)->except(['create', 'show', 'edit']);
    Route::resource('products', ProductController::class)->except(['create', 'show', 'edit']);
    Route::resource('tax-or-discounts', TaxAndDiscountController::class)->only(['index', 'store', 'update']);
    Route::resource('orders', PosController::class)->except(['show', 'edit']);
});

<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaxAndDiscountController;
use App\Http\Controllers\PosController;


Route::get('/error', [IndexController::class, 'index'])->name('error');
Route::get('/typography', [IndexController::class, 'index'])->name('typography');
Route::get('/root/test', [IndexController::class, 'index'])->name('root.test');
Route::get('/root/test-two', [IndexController::class, 'view'])->name('root.test.two');
Route::get('/main', [IndexController::class, 'index'])->name('main');
Route::get('/main/test', [IndexController::class, 'index'])->name('main.test');
Route::get('/main/test-two', [IndexController::class, 'index'])->name('main.test.two');
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
    Route::resource('orders', PosController::class);
});
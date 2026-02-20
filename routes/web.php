<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\WorkOrderController;


Route::get('/', function () {
    return view('welcome');
})->name('home');



Route::middleware('auth')->group(function () {
    Route::resource('dashboard', DashboardController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('products', ProductController::class);

    Route::resource('branches', BranchController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('work_orders', WorkOrderController::class)->names('work_orders');

    Route::post('/services/{service}/start', [App\Http\Controllers\ServiceController::class, 'startService'])->name('services.start');
    Route::post('/services/{service}/finish', [App\Http\Controllers\ServiceController::class, 'finishService'])->name('services.finish');
});


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('branches', BranchController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('categories', CategoryController::class);
});


require __DIR__.'/auth.php';

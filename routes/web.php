<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
 
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('landing-page');
    })->name('landing');
 
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
 
Route::middleware('auth')->group(function () {

    Route::middleware('isStaff')->group(function () {
        Route::get('/operator/dashboard', function () {
            return view('admin.dashboard');
        })->name('operator.dashboard');
    });
 
    Route::middleware('isAdmin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
 
        Route::resource('admin/categories', CategoryController::class)->except(['create', 'show', 'edit'])->names('admin.categories');
        Route::get('/admin/categories/export', [CategoryController::class, 'exportExcel'])->name('admin.categories.export');
 
        Route::get('/admin/items/export', [ItemController::class, 'exportExcel'])->name('admin.items.export');
        Route::resource('admin/items', ItemController::class)->except(['create', 'show', 'edit'])->names('admin.items');
        Route::get('/admin/items/detail-lending', [ItemController::class, 'detailLending'])->name('admin.items.detail-lending');
 
        Route::get('/admin/users', [UserController::class, 'indexAdmin'])->name('admin.users.index');
        Route::get('/admin/operators', [UserController::class, 'indexOperator'])->name('admin.operators.index');
        Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
 
        Route::get('/export-data-admin', [UserController::class, 'exportAdmin'])->name('export.admin');
        Route::get('/export-data-operator', [UserController::class, 'exportOperator'])->name('export.operator');
    });
 

 
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
 
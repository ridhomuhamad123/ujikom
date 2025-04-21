<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Halaman login

Route::middleware(['Guest'])->group( function() {
    Route::get('/login', [UserController::class, 'loginpage'])->name('loginpage');
    Route::post('/login', [UserController::class, 'login'])->name('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    

    Route::prefix('/purchases')->name('purchases.')->group(function () {
        Route::get('/', [PurchaseController::class, 'index'])->name('index');

        Route::get('/', [PurchaseController::class, 'index'])->name('index');
        Route::get('/create', [PurchaseController::class, 'create'])->name('create');
        Route::post('/create/post', [PurchaseController::class, 'post'])->name('post');
        Route::post('/create/store', [PurchaseController::class, 'store'])->name('store');
        Route::get('/member-form', [PurchaseController::class, 'memberForm'])->name('memberForm');
        Route::post('/member-store', [PurchaseController::class, 'storeMember'])->name('storeMember');
        Route::get('/detail-print/{id}', [PurchaseController::class, 'detailPrint'])->name('detailPrint');
        Route::get('lihat/{id}', [PurchaseController::class, 'lihat'])->name('lihat');
        Route::get('export-pdf/{id}', [PurchaseController::class, 'exportPdf'])->name('export-pdf');
        Route::get('/export_excel', [PurchaseController::class, 'export_excel'])->name('export_excel');

    });

    Route::prefix('/products')->name('products.')->group(function() {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('update');
        Route::put('/{id}/upgrade-stock', [ProductController::class, 'updatestock'])->name('updatestock');
        Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('delete');
    });
    
    Route::middleware('isAdmin')->group( function() {
        Route::prefix('/users')->name('users.')->group( function() {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('destroy');


        });
    });

    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
});
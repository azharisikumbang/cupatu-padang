<?php

use App\Http\Controllers\CartManagementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderCreatedController;
use App\Http\Controllers\OrderCustomerInfoController;
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

Route::get('/', [HomeController::class, '__invoke'])->name('homepage');
Route::get('/buat-pesanan', [OrderController::class, 'create'])->name('order.create');
Route::get('/buat-pesanan/informasi-pelanggan', [OrderCustomerInfoController::class, 'create'])->name('order-customer-info.create');
Route::post('/buat-pesanan/informasi-pelanggan', [OrderCustomerInfoController::class, 'store'])->name('order-customer-info.store');
Route::get('/buat-pesanan/selesai/{order}', [OrderCreatedController::class, '__invoke'])->name('order-created');

// cart
Route::get('/api/cart', [CartManagementController::class, 'index'])->name('api.cart.index');
Route::post('/api/cart/add', [CartManagementController::class, 'store'])->name('api.cart.store');
Route::delete('/api/cart/{key}', [CartManagementController::class, 'destroy'])->name('api.cart.destroy');

require __DIR__ .'/customer.php';
require __DIR__ .'/administrator.php';
require __DIR__ .'/manager.php';
require __DIR__ .'/auth.php';

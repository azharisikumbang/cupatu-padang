<?php

use App\Http\Controllers\Administrator\DashboardController;
use App\Http\Controllers\Administrator\ExportOrderInvoicePdfController;
use App\Http\Controllers\Administrator\OrderController;
use App\Http\Controllers\Administrator\OrderStatusUpdaterController;
use App\Http\Controllers\Administrator\ServiceManagementController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix'=> '/administrator', 'middleware' => ['role:administrator'], 'as' => 'administrator.'],
    function () {
        Route::get('/dashboard', [DashboardController::class, '__invoke'])->name("dashboard.index");
        Route::get('/orders', [OrderController::class, 'index'])->name("order.index");
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name("order.show");
        Route::post('/order/{order}/status/{action}', [OrderStatusUpdaterController::class, '__invoke'])->name('order-status-updater.store')->where('action', 'next|prev');

        Route::get('/order/{order}/invoice', [ExportOrderInvoicePdfController::class, '__invoke'])->name('order-invoice.export');
        
        Route::resource('/services', ServiceManagementController::class);
});
<?php

use App\Http\Controllers\Administrator\DashboardController;
use App\Http\Controllers\Administrator\OrderController;
use App\Http\Controllers\Administrator\ServiceManagementController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix'=> '/administrator', 'middleware' => ['role:administrator'], 'as' => 'administrator.'],
    function () {
        Route::get('/dashboard', [DashboardController::class, '__invoke'])->name("dashboard.index");
        Route::get('/orders', [OrderController::class, 'index'])->name("order.index");
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name("order.show");

        Route::resource('/services', ServiceManagementController::class);
});
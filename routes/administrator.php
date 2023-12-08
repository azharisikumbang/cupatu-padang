<?php

use App\Http\Controllers\Administrator\DashboardController;
use App\Http\Controllers\Administrator\OrderController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix'=> '/administrator', 'middleware' => ['role:administrator']],
    function () {
        Route::get('/dashboard', [DashboardController::class, '__invoke'])->name("administrator.dashboard.index");
        Route::get('/orders', [OrderController::class, 'index'])->name("administrator.order.index");
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name("administrator.order.show");
});
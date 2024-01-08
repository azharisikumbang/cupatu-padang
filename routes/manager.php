<?php

use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\OrderReportingController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix'=> '/manager', 'middleware' => ['role:manager'], 'as' => 'manager.'],
    function () {
        Route::get('/dashboard', [DashboardController::class, '__invoke'])->name("dashboard.index");
        Route::get('/laporan-pemesanan', [OrderReportingController::class, '__invoke'])->name("order-reporting");
});
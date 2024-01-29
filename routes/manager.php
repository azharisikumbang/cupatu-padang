<?php

use App\Http\Controllers\Manager\AccountPasswordController;
use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\IncomeReportController;
use App\Http\Controllers\Manager\OrderReportController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix'=> '/manager', 'middleware' => ['role:manager'], 'as' => 'manager.'],
    function () {
        Route::get('/dashboard', [DashboardController::class, '__invoke'])->name("dashboard.index");
        Route::get('/laporan-pemesanan', [OrderReportController::class, '__invoke'])->name("order-reporting");
        Route::get('/laporan-pendapatan', [IncomeReportController::class, '__invoke'])->name("income-reporting");

        Route::get('/change-password', [AccountPasswordController:: class, 'edit'])->name('change-password');
});
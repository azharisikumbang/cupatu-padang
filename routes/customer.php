<?php

use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['middleware' => ['role:customer']],
    function () {
        Route::get('/dashboard', [DashboardController::class, '__invoke'])->name("dashboard.index");

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
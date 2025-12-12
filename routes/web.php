<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\TwoFactorController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:admin')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.submit');
});

Route::get('/two-factor-challenge', [TwoFactorController::class, 'challenge'])->name('admin.two-factor.challenge');
Route::post('/two-factor-challenge', [TwoFactorController::class, 'verify'])->name('admin.two-factor.verify');

Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout')->middleware('auth:admin');

require __DIR__.'/admin.php';

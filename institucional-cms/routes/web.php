<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/settings', [AdminController::class, 'showSettingsPage'])->name('settings.page');
    Route::get('/company', [AdminController::class, 'showCompanyPage'])->name('company.page');
    Route::get('/menu', [AdminController::class, 'showMenuPage'])->name('menu.page');
    Route::get('/sliders', [AdminController::class, 'showSlidersPage'])->name('sliders.page');
    Route::get('/password', [AdminController::class, 'showPasswordPage'])->name('password.page');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::post('/company', [AdminController::class, 'updateCompanySettings'])->name('company.update');
    Route::post('/menu', [AdminController::class, 'updateMenu'])->name('menu.update');
    Route::post('/menu/default', [AdminController::class, 'resetMenuDefaults'])->name('menu.default');
    Route::post('/sliders', [AdminController::class, 'storeSlider'])->name('sliders.store');
    Route::put('/sliders', [AdminController::class, 'updateSliders'])->name('sliders.update');
    Route::delete('/sliders/{slider}', [AdminController::class, 'destroySlider'])->name('sliders.destroy');
    Route::post('/password', [AdminController::class, 'updatePassword'])->name('password.update');
});

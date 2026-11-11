<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingsController;

// Pública
Route::get('/', [HomeController::class, 'index'])->name('home');

// Checkout y Pedidos en Base de Datos
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.form');
Route::post('/checkout', [OrderController::class, 'process'])->name('checkout.process');
Route::get('/ticket/{order}', [OrderController::class, 'ticket'])->name('orders.ticket');

// Autenticación & Registro de Clientes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/registro', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/registro', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Panel Administrativo Protegido
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Módulo Principal: CRUD de Productos
    Route::resource('products', ProductController::class);

    // CMS Ligero: Configuración y textos de la portada
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/restore', [SettingsController::class, 'restore'])->name('settings.restore');
});

<?php

use App\Http\Controllers\ArsipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('/user', UserController::class);
    Route::resource('/kategori', KategoriController::class);
    Route::resource('/arsip', ArsipController::class);
    Route::post('arsip/{id}/validasi', [ArsipController::class, 'validasi'])->name('arsip.validasi');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
});

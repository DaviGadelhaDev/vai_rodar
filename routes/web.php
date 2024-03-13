<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Login
Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'index')->name('login.index');
    Route::post('/login', 'loginProcess')->name('login.process');
    Route::get('/create-user-login', 'create')->name('login.create-user');
    Route::post('/store-user-login', 'store')->name('login.store-user');
});

//Recuperar senha
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('/forgot-password', 'showForgotPassword')->name('forgot-password.show');
    Route::post('/forgot-password', 'submitForgotPassword')->name('forgot-password.submit');
    Route::get('/reset-password/{token}', 'showResetPassword')->name('reset-password.show');
    Route::post('/reset-password', 'submitResetPassword')->name('reset-password.submit');
    Route::post('/', [LoginController::class, 'index'])->name('password.reset');
});

//Dashboard
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});

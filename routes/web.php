<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;


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
    Route::post('/store', 'store')->name('login.store');
    Route::get('/create', 'create')->name('login.create');
    Route::post('/create', 'storeNewUser')->name('login.storeNewUser');
    
});

//Esqueceu senha
Route::controller(ForgotPasswordController::class)->group(function (){
    Route::get('/forgotPassword', 'index')->name('forgot.index');
    Route::post('/forgotPassword', 'store')->name('forgot.store');
    Route::post('/', [LoginController::class, 'index'])->name('password.reset');
    Route::get('/reset-password/{token}', 'showResetPassword')->name('reset-password.show');
    Route::post('/reset-password', 'submitResetPassword')->name('resetPassword.submit');
});

//
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/destroy', [LoginController::class, 'destroy'])->name('login.destroy');
});
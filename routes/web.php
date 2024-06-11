<?php

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
Route::controller(LoginController::class)->group(function (){
    Route::get('/', 'index')->name('login.index');
    Route::post('/store', 'store')->name('login.store');
    Route::get('/create', 'create')->name('login.create');
    Route::post('/create', 'storeNewUser')->name('login.storeNewUser');
    
});


//
Route::group(['middleware' => 'auth'], function (){
    //Dashboard
    Route::controller(DashboardController::class)->group(function (){
        Route::get('/dashboard', 'index')->name('dashboard.index');
    });
    
    //Logout
    Route::controller(LoginController::class)->group(function (){
        Route::get('/destroy', 'destroy')->name('login.destroy');
    });

    //Profile
    Route::controller(ProfileController::class)->group(function (){
        Route::get('/Profile', 'index')->name('profile.index');
    });

    
    //users
    Route::controller(UserController::class)->group(function (){
        Route::get('/users', 'index')->name('user.index');
        Route::get('/createUser', 'create')->name('user.create');
        Route::post('/storeUser', 'storeUser')->name('user.store');
        Route::get('/showUser/{user}', 'show')->name('user.show');
        Route::get('/editUser/{user}', 'edit')->name('user.edit');
        Route::put('/updateUser/{user}', 'update')->name('user.update');
        Route::delete('/deleteUser/{user}', 'destroy')->name('user.delete');
    });
});
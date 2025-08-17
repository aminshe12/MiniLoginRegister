<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'auth', 'middleware' => 'web'], function () {
    Route::get ('/', [LoginController::class, 'showLoginForm']);
    Route::post ('/check-mobile', [LoginController::class, 'checkMobile'])->name('check-mobile');
    Route::post ('/check-password', [LoginController::class, 'checkMobile'])->name('check-password');
    Route::post ('/check-otp', [LoginController::class, 'checkMobile'])->name('check-otp');
});

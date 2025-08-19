<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? view('dashboard') : redirect('/auth');
});

Route::group(['prefix' => 'auth', 'middleware' => 'web'], function () {
    Route::get  ('/',               [LoginController::class, 'showLoginForm']);
    Route::post ('/check-mobile',   [LoginController::class, 'checkMobile'])->name('check-mobile');
    Route::post ('/check-password', [LoginController::class, 'checkPassword'])->name('check-password');
    Route::post ('/check-otp',      [LoginController::class, 'checkOtp'])->name('check-otp');
    Route::post ('/register',       [LoginController::class, 'registerUser'])->name('register-user');
    Route::post ('/logout',         [LoginController::class, 'logout'])->name('logout');
});

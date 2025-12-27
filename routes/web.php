<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('login'); // login + signup 1 blade
});

// LOGIN
Route::post('/login', [LoginController::class, 'login'])
    ->name('login.process');

// REGISTER
Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');

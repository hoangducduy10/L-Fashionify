<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    // Auth API
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login')->name('auth.login');
        Route::post('register', 'register')->name('auth.register');

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/user', 'me')->name('auth.me');
            Route::post('logout', 'logout')->name('auth.logout');
            Route::post('change-password', 'changePassword')->name('auth.changePassword');
        });
    });

    // User API
    Route::controller(UserController::class)->group(function () {
        Route::get('users', 'getAllUsers')->name('users.getAllUsers');
        Route::get('users/{id}', 'getUserById')->name('users.getUserById');

        Route::middleware('auth:sanctum')->group(function () {
            Route::put('users/{id}', 'update')->name('users.update');
            Route::delete('users/{id}', 'destroy')->name('users.destroy');
        });
    });
});

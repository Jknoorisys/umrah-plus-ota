<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['localization'])->group(function () {
    // Admin APIs
    Route::prefix('admin')->group(function () {
        Route::post('login' , [AuthController::class, 'login']);
        Route::group(['middleware' => 'jwt.verify'], function () {
            Route::post('change-password', [ProfileController::class, 'changePassword']);
            Route::post('profile', [ProfileController::class, 'getProfile']);
        });
    });

  
});


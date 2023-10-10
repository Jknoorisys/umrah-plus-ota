<?php

use App\Http\Controllers\api\admin\AuthController;
use App\Http\Controllers\api\admin\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\user\AuthController as UserAuthController;
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

    Route::prefix('user')->group(function () {
        Route::post('register' , [UserAuthController::class, 'register']);
        Route::post('verifyOTP',[UserAuthController::class,'verifyOTP']);
        Route::post('resendregOTP',[UserAuthController::class,'resendRegOTP']);
        Route::post('login' , [UserAuthController::class, 'login']);
        Route::post('forgetpassword' , [UserAuthController::class, 'forgetpassword']);
        Route::post('forgotPasswordValidate',[UserAuthController::class,'forgotPasswordValidate']);
        Route::group(['middleware' => 'jwt.verify'], function () {
            Route::post('changepassword', [ProfileController::class, 'changePassword']);
            Route::post('getProfile', [ProfileController::class, 'getProfile']);
        });
    
    });
  
});


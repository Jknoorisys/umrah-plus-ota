<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\ManageUsers;
use App\Http\Controllers\admin\ProfileController;
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

Route::middleware(['guest'])->group(function () {
    Route::any('/', function () {
        return view('login');
    })->name('/');

    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::any('forget-password', function () {
        return view('forget_password');
    })->name('forget-password');

    Route::post('send-reset-link', [AuthController::class, 'sendResetLinkEmail'])->name('send-reset-link');

    Route::any('reset-password/{token}', function ($token) {
        return view('reset_password', ['token' => $token]);
    })->name('password.reset');

    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('reset-password.post');
});

Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:admin'])->group(function () {
    Route::any('dashboard' , [ProfileController::class, 'dashboard'])->name('dashboard');
    Route::any('profile' , [ProfileController::class, 'profile'])->name('profile');
    Route::post('update-profile' , [ProfileController::class, 'updateProfile'])->name('update-profile');
    Route::post('upload-image' , [ProfileController::class, 'uploadImage'])->name('upload-image');
    Route::any('settings' , [ProfileController::class, 'settings'])->name('settings');
    Route::post('change-password' , [ProfileController::class, 'changePassword'])->name('change-password');

    Route::prefix('user')->group(function () {
        Route::get('list' , [ManageUsers::class, 'list'])->name('user.list');
    });

});



<?php

use App\Http\Controllers\admin\AuthController;
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
    })->name('/');    Route::post('login', 'Auth\LoginController@login');

    Route::post('login', [AuthController::class, 'login'])->name('login');

});

// Route::any('/', function () {
//     return view('login');
// })->name('/');


// Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:admin'])->group(function () {
    Route::any('dashboard' , [ProfileController::class, 'dashboard'])->name('dashboard');
    Route::any('profile' , [ProfileController::class, 'profile'])->name('profile');
    Route::post('update-profile' , [ProfileController::class, 'updateProfile'])->name('update-profile');
    Route::post('upload-image' , [ProfileController::class, 'uploadImage'])->name('upload-image');
    Route::post('get-phone-code' , [ProfileController::class, 'getPhoneCode'])->name('get-phone-code');
});



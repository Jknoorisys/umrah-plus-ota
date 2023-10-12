<?php

use App\Http\Controllers\admin\AuthController;
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
    Route::get('dashboard', function () {
        return view('admin.layouts.app');
    })->name('dashboard');
});



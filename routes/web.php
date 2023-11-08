<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\ManageMarkups;
use App\Http\Controllers\admin\ManagePromoCodes;
use App\Http\Controllers\admin\ManageRoles;
use App\Http\Controllers\admin\ManageSubAdmins;
use App\Http\Controllers\admin\ManageUsers;
use App\Http\Controllers\admin\ManageVisaCountry;
use App\Http\Controllers\admin\ManageVisaTypes;
use App\Http\Controllers\admin\ProfileController;
use Illuminate\Support\Facades\App;
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
Route::get('setlocale/{locale}', function ($locale) {
    App::setLocale($locale);
    session(['locale' => $locale]);
    return redirect()->back();
})->name('setlocale');

Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
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
    Route::get('mark-all-read', [ProfileController::class, 'markAllRead'])->name('mark-all-read');


    Route::prefix('user')->group(function () {
        Route::get('list' , [ManageUsers::class, 'list'])->name('user.list');
        Route::post('change-status' , [ManageUsers::class, 'changeStatus'])->name('user.change-status');
        Route::post('delete' , [ManageUsers::class, 'delete'])->name('user.delete');
        Route::get('view/{id}' , [ManageUsers::class, 'view'])->name('user.view');
        Route::get('send-notification' , [ManageUsers::class, 'sendNotificationForm'])->name('user.send-notification-form');
        Route::post('send-notification' , [ManageUsers::class, 'sendNotification'])->name('user.send-notification');
    });

    Route::prefix('sub-admin')->group(function () {
        Route::get('list' , [ManageSubAdmins::class, 'list'])->name('sub-admin.list');
        Route::get('add' , [ManageSubAdmins::class, 'addForm'])->name('sub-admin.add-form');
        Route::post('add' , [ManageSubAdmins::class, 'add'])->name('sub-admin.add');
        Route::get('view/{id}' , [ManageSubAdmins::class, 'view'])->name('sub-admin.view');
        Route::get('edit/{id}' , [ManageSubAdmins::class, 'editForm'])->name('sub-admin.edit-form');
        Route::post('edit' , [ManageSubAdmins::class, 'edit'])->name('sub-admin.edit');
        Route::post('delete' , [ManageSubAdmins::class, 'delete'])->name('sub-admin.delete');
        Route::post('change-status' , [ManageSubAdmins::class, 'changeStatus'])->name('sub-admin.change-status');

    });

    Route::prefix('role')->group(function () {
        Route::get('list' , [ManageRoles::class, 'list'])->name('role.list');
        Route::get('add' , [ManageRoles::class, 'addForm'])->name('role.add-form');
        Route::post('add' , [ManageRoles::class, 'add'])->name('role.add');
        Route::get('view/{id}' , [ManageRoles::class, 'view'])->name('role.view');
        Route::get('edit/{id}' , [ManageRoles::class, 'editForm'])->name('role.edit-form');
        Route::post('edit' , [ManageRoles::class, 'edit'])->name('role.edit');
        Route::post('delete' , [ManageRoles::class, 'delete'])->name('role.delete');
        Route::post('change-status' , [ManageRoles::class, 'changeStatus'])->name('role.change-status');

    });

    Route::prefix('promo-code')->group(function () {
        Route::get('list' , [ManagePromoCodes::class, 'list'])->name('promo-code.list');
        Route::get('add' , [ManagePromoCodes::class, 'addForm'])->name('promo-code.add-form');
        Route::post('add' , [ManagePromoCodes::class, 'add'])->name('promo-code.add');
        Route::get('edit/{id}' , [ManagePromoCodes::class, 'editForm'])->name('promo-code.edit-form');
        Route::post('edit' , [ManagePromoCodes::class, 'edit'])->name('promo-code.edit');
        Route::post('delete' , [ManagePromoCodes::class, 'delete'])->name('promo-code.delete');
        Route::post('change-status' , [ManagePromoCodes::class, 'changeStatus'])->name('promo-code.change-status');
    });

    Route::prefix('markup')->group(function () {
        Route::get('list' , [ManageMarkups::class, 'list'])->name('markup.list');
        Route::post('edit' , [ManageMarkups::class, 'edit'])->name('markup.edit');
    });

    Route::prefix('visa-country')->group(function () {
        Route::get('list' , [ManageVisaCountry::class, 'list'])->name('visa-country.list');
        Route::post('add' , [ManageVisaCountry::class, 'add'])->name('visa-country.add');
        Route::any('edit/{id}' , [ManageVisaCountry::class, 'editForm'])->name('visa-country.edit');
        Route::any('update' , [ManageVisaCountry::class, 'edit'])->name('visa-country.update');
        Route::post('delete' , [ManageVisaCountry::class, 'delete'])->name('visa-country.delete');
        Route::post('change-status' , [ManageVisaCountry::class, 'changeStatus'])->name('visa-country.change-status');
        Route::post('toggle-featured', [ManageVisaCountry::class, 'toggleFeatured'])->name('visa-country.toggle-featured');
    });

    Route::prefix('visa-type')->group(function () {
        Route::get('list' , [ManageVisaTypes::class, 'list'])->name('visa-type.list');
        Route::get('add' , [ManageVisaTypes::class, 'addForm'])->name('visa-type.add-form');
        Route::post('add' , [ManageVisaTypes::class, 'add'])->name('visa-type.add');
        Route::get('edit/{id}' , [ManageVisaTypes::class, 'editForm'])->name('visa-type.edit-form');
        Route::post('edit' , [ManageVisaTypes::class, 'edit'])->name('visa-type.edit');
        Route::post('delete' , [ManageVisaTypes::class, 'delete'])->name('visa-type.delete');
        Route::post('change-status' , [ManageVisaTypes::class, 'changeStatus'])->name('visa-type.change-status');
        Route::post('toggle-featured', [ManageVisaTypes::class, 'toggleFeatured'])->name('visa-type.toggle-featured');
    });

});



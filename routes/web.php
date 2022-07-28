<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\InfoController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InfoController as PublicInfoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('login', [UserController::class, 'login'])->name('login');
    Route::post('login', [UserController::class, 'postLogin'])->name('postLogin');
});

Route::get('/info/{info}', PublicInfoController::class)->name('info');

Route::middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'home'])->name('home');

    Route::any('/logout', [UserController::class, 'logout'])->name('logout');

    Route::prefix('admin')->middleware('role:admin')->name('admin.')->group(function () {
        Route::resource('customer', CustomerController::class)->except('create', 'edit');
        Route::post('customer/import', [CustomerController::class, 'import'])->name('customer.import');
        Route::get('/customer/{customer}/transaksi', [CustomerController::class, 'transaksi'])->name('customer.transaksi');
        
        Route::resource('info', InfoController::class);
        Route::post('/info/ckeditor/upload', [InfoController::class, 'upload'])->name('info.upload');

        Route::resource('transaksi', TransaksiController::class);
        
        Route::get('account', [AccountController::class, 'index'])->name('account.index');
        Route::post('account/password', [AccountController::class, 'password'])->name('account.password');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings/{setting}', [SettingController::class, 'update'])->name('settings.update');
        Route::get('settings/tools/{setting}', [SettingController::class, 'tools'])->name('settings.tools');
    });
});

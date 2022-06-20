<?php

use App\Http\Controllers\Api\InfoController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('guest:api')->group(function () {
    Route::post('login', [UserController::class, 'login']);
});

Route::get('/info', [InfoController::class, 'index']);
Route::get('/setting', SettingController::class);

Route::middleware('auth:api')->group(function () {
    Route::middleware('role:customer')->group(function () {
        Route::get('/user', [UserController::class, 'index']);
        Route::post('/user/change-password', [UserController::class, 'changePassword']);

        Route::prefix('/transaksi')->group(function () {
            Route::get('/', [TransaksiController::class, 'index']);
            Route::post('/bayar', [TransaksiController::class, 'bayar']);
        });
    });
});
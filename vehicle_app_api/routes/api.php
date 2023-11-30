<?php

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\MockData\VehicleDataController;
use App\Http\Controllers\v1\VehicleController;
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
Route::group(['prefix' => 'v1'], function () {
    
    Route::controller(AuthController::class)->prefix('auth')->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::post('/verify-code', 'verifyCode');
        Route::post('/resend-code/{id}', 'resendCode');
        Route::post('/forgot-password', 'forgotPassword');
        Route::post('/reset-password', 'resetPassword');

        Route::middleware(['auth:api'])->group(function () {
            Route::post('/logout', 'logout');
            Route::post('/refresh', 'refreshToken');
            Route::get('/me', 'me');
        });
    });

    Route::middleware(['auth:api'])->group(function () {
        Route::controller(VehicleController::class)->prefix('vehicle')->group(function () {
            Route::post('/vin', 'getClientVin');
        });
    });

    Route::controller(VehicleDataController::class)->prefix('mock-data')->group(function () {
        Route::post('/verify-vin', 'getVin');
    });
});

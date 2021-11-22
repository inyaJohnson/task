<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ClientAuth\LoginController as ClientLogin;
use App\Http\Controllers\ClientAuth\RegisterController as ClientRegistration;
use App\Http\Controllers\ClientAuth\LogoutController as ClientLogout;
use App\Http\Controllers\ClientAuth\ForgotPasswordController as ClientForgotPassword;
use App\Http\Controllers\ClientAuth\ResetPasswordController as ClientResetPassword;
use App\Http\Controllers\ClientController;

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

Route::group(['prefix' => 'auth'], function ($router) {
    Route::group(['middleware' => 'guest:api'], function () {
        Route::post('login', LoginController::class);
        Route::post('register', RegisterController::class);
        Route::patch('forgot-password/{token}', [ForgotPasswordController::class, 'storeNewPassword']);
        Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('logout', LogoutController::class);
        Route::patch('reset-password', ResetPasswordController::class);
    });
});

Route::group(['middleware' => 'auth:api'], function () {
    // Client
    Route::resource('clients', ClientController::class);
});

Route::group(['prefix' => 'client-auth'], function ($router) {
    Route::group(['middleware' => 'guest:client'], function () {
        Route::post('login', ClientLogin::class);
        Route::post('register', ClientRegistration::class);
        Route::patch('forgot-password/{token}', [ClientForgotPassword::class, 'storeNewPassword']);
        Route::post('forgot-password', [ClientForgotPassword::class, 'sendResetLinkEmail']);
    });

    Route::group(['middleware' => 'auth:client'], function () {
        Route::post('logout', ClientLogout::class);
        Route::patch('reset-password', ClientResetPassword::class);
    });
});

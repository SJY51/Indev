<?php


use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\UserController;
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
    Route::group(['prefix' => 'auth'], function () {
        Route::group(['middleware' => 'auth.guest:api'], function () {
            Route::post('/login', LoginController::class);
        });
//        Route::post('/logout', LogoutController::class)->middleware('auth:api');
    });

    Route::group(['middleware' => 'jwt'], function () {
        Route::group(['middleware' => ['auth:api']], function () {

            Route::group(['prefix' => 'user'], function () {
                Route::post('/', [UserController::class, 'create']);

//                Route::group(['prefix' => 'editing'], function () {
//                    Route::post('information', InformationController::class);
//                });
            });
        });

    });


});


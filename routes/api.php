<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function () {

    Route::post('movies', [MovieController::class, 'store']);
    Route::get('movies', [MovieController::class, 'index']);

    Route::get('user', [AuthController::class, 'user']);

});

Route::group(['prefix' => 'v1', 'middleware' => 'api'], function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

});

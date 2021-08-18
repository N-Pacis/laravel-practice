<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;


Route::group(['middleware' => 'api','prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::group(['middleware'=>['api','authorize']],function(){
    Route::post('store-file',[DocumentController::class, 'store']);
    Route::get('/profile', [AuthController::class, 'userProfile']);   
    Route::prefix("auth")->group(function(){
    });
});
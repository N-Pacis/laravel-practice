<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

Route::group(['middleware' => 'api','prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::group(['middleware'=>['api','authorize']],function(){
    Route::post('store-file',[DocumentController::class, 'store']);
    Route::prefix("auth")->group(function(){
        Route::get('/profile',[AuthController::class,'userProfile']);
    });
});
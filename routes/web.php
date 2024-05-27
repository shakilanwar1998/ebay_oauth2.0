<?php

use Illuminate\Support\Facades\Route;

Route::get('/auth',[\App\Http\Controllers\AuthenticationController::class,'handleRedirect']);
Route::get('/token',[\App\Http\Controllers\AuthenticationController::class,'getAccessToken']);

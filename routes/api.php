<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('device')->controller(DeviceController::class)->group(function () {
    Route::post('/register', 'register');
});

Route::middleware('auth:device')
    ->prefix('subscription')
    ->controller(SubscriptionController::class)->group(function () {
        Route::get('/check', 'check');
    });

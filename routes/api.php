<?php

use App\Http\Controllers\NotificationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
    Route::get('/', function () {
        return response()->json(
            'Welcome'
        );
    });

    Route::controller(NotificationsController::class)->prefix('notifications')->name('notifications.')->group(function () {
        Route::post('/', 'store');
    });
});

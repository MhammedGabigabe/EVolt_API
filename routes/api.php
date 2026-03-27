<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorneController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SessionChargeController;
use App\Http\Controllers\StatsController;

Route::Post ('/register',[AuthController::class, 'register']);
Route::Post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {   
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/bornes/search', [BorneController::class, 'search']);
    Route::apiResource('bornes', BorneController::class);
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::put('/reservations/{reservation}', [ReservationController::class, 'update']);
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy']);
    Route::get('/my-sessions', [SessionChargeController::class, 'mySessions']);
    Route::post('/sessions/start/{reservation}', [SessionChargeController::class, 'startSession']);
    Route::post('/sessions/end/{session}', [SessionChargeController::class, 'endSession']);
    Route::get('/admin/bornes/stats', [StatsController::class, 'bornes']);
});



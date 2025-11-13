<?php

use App\Http\Controllers\Api\Guest\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('reservations', [ReservationController::class, 'index']);

<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SmsController;
use Illuminate\Support\Facades\Route;

Route::prefix('projects')->group(function (): void {
    Route::post('/', [ProjectController::class, 'store']);
    Route::patch('{project}/provider', [ProjectController::class, 'updateProvider']);
});

Route::prefix('sms')->group(function (): void {
    Route::post('send', [SmsController::class, 'send']);
    Route::get('history', [SmsController::class, 'history']);
});

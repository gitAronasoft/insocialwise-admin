<?php

use App\Http\Controllers\Api\SubscriptionPlanApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/subscription-plans', [SubscriptionPlanApiController::class, 'index']);
    Route::get('/subscription-plans/{id}', [SubscriptionPlanApiController::class, 'show']);
    Route::get('/stripe/config', [SubscriptionPlanApiController::class, 'stripeConfig']);
});

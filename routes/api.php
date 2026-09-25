<?php

use App\Http\Controllers\Api\V1\ApiAuthController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\PackageController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Payment\WebhookPaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('throttle:api')->group(function () {
    Route::post('/hotspot/purchase', [
        \App\Http\Controllers\Hotspot\HotspotPortalController::class,
        'purchase',
    ]);
    Route::post('/auth/token', [ApiAuthController::class, 'token']);

    Route::post('/payment/bkash/ipn', [WebhookPaymentController::class, 'handleBkashIpn']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/revoke', [ApiAuthController::class, 'revoke']);

        Route::get('/health', function () {
            return response()->json(['success' => true, 'service' => config('app.name'), 'api_version' => 'v1']);
        });

        Route::get('/user', fn (Request $request) => response()->json(['success' => true, 'data' => $request->user()]));
        Route::get('/packages', [PackageController::class, 'index']);

        Route::get('/customers', [CustomerController::class, 'index']);
        Route::get('/customers/{customerUniqueId}', [CustomerController::class, 'show']);
        Route::get('/customers/{customerUniqueId}/billing', [CustomerController::class, 'billing']);
        Route::get('/customers/{customerUniqueId}/payments', [CustomerController::class, 'payments']);

        Route::post('/payments', [PaymentController::class, 'initiate']);
        Route::get('/payments/{merchantReference}', [PaymentController::class, 'show']);
        Route::post('/payments/{merchantReference}/check', [PaymentController::class, 'check']);
    });

    // Provider callbacks remain public; they must be authenticated/verified by the provider-specific handlers.
    Route::post('/payment/mfs/sms-receiver', [WebhookPaymentController::class, 'handleSmsReceiver']);
    Route::post('/payment/beem/bpay/webhook', [\App\Http\Controllers\Payment\TanzaniaPaymentController::class, 'beemBpayWebhook']);
    Route::post('/payment/azampesa/webhook', [\App\Http\Controllers\Payment\TanzaniaPaymentController::class, 'azampesaWebhook']);
});

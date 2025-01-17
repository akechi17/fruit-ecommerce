<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DiscountController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('admin', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group([
    'middleware' => 'api'
], function () {
    Route::resources([
        'sliders' => SliderController::class,
        'products' => ProductController::class,
        'customers' => CustomerController::class,
        'testimonies' => TestimoniController::class,
        'reviews' => ReviewController::class,
        'orders' => OrderController::class,
        'payments' => PaymentController::class,
        'discounts' => DiscountController::class,
    ]);

    Route::get('pesanan/baru', [OrderController::class, 'baru']);
    Route::get('pesanan/confirmed', [OrderController::class, 'confirmed']);
    Route::get('pesanan/packed', [OrderController::class, 'packed']);
    Route::get('pesanan/sent', [OrderController::class, 'sent']);
    Route::get('pesanan/received', [OrderController::class, 'received']);
    Route::get('pesanan/finished', [OrderController::class, 'finished']);
    Route::post('pesanan/ubah_status/{order}', [OrderController::class, 'ubah_status']);
    Route::get('reports', [ReportController::class, 'get_reports']);
});

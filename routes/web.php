<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::post('login', [AuthController::class, 'login_customer']);
// Route::post('logout', [AuthController::class, 'logout_customer']);
// auth
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout']);

Route::get('login_customer', [AuthController::class, 'login_customer']);
Route::post('login_customer', [AuthController::class, 'login_customer_action']);
Route::get('logout_customer', [AuthController::class, 'logout_customer']);

Route::get('register_customer', [AuthController::class, 'register_customer']);
Route::post('register_customer', [AuthController::class, 'register_customer_action']);
Route::get('/barang', [ProductController::class, 'list']);
Route::get('/discounts', [DiscountController::class, 'list']);
Route::get('/reviews', [ReviewController::class, 'list']);
Route::get('/payment', [PaymentController::class, 'list']);

Route::get('/pesanan/baru', [OrderController::class, 'list']);
Route::get('/pesanan/confirmed', [OrderController::class, 'confirmed_list']);
Route::get('/pesanan/sent', [OrderController::class, 'sent_list']);
Route::get('/pesanan/packed', [OrderController::class, 'packed_list']);
Route::get('/pesanan/received', [OrderController::class, 'received_list']);
Route::get('/pesanan/finished', [OrderController::class, 'finished_list']);

Route::get('/report', [ReportController::class, 'index']);

Route::get('/home', [DashboardController::class, 'index']);

Route::get('/', [HomeController::class, 'index']);
Route::get('/stores/{category}', [HomeController::class, 'products']);
Route::get('/store/{id}', [HomeController::class, 'product']);
Route::get('/cart', [HomeController::class, 'cart']);
Route::get('/checkout', [HomeController::class, 'checkout']);
Route::get('/orders', [HomeController::class, 'orders']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/faq', [HomeController::class, 'faq']);

Route::post('/add_to_cart', [HomeController::class, 'add_to_cart']);
Route::get('/delete_from_cart/{cart}', [HomeController::class, 'delete_from_cart']);
Route::get('/get_city/{id}', [HomeController::class, 'get_city']);
Route::get('/get_ongkir/{destination}/{weight}', [HomeController::class, 'get_ongkir']);
Route::post('/checkout_orders', [HomeController::class, 'checkout_orders']);
Route::post('/payments', [HomeController::class, 'payments']);
Route::post('/pesanan_selesai/{order}', [HomeController::class, 'pesanan_selesai']);
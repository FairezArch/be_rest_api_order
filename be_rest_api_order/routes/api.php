<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('/product', ProductController::class);

Route::post('/cart', [OrderController::class, 'cart']);
Route::post('/checkout', [OrderController::class, 'checkout']);
Route::get('/order', [OrderController::class, 'order']);
Route::get('/summary', [OrderController::class, 'summary']);

Route::get('/export', [ExportController::class, 'export']);


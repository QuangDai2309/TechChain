
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth')->get('/user', function (Request $request) {
    // Trả về thông tin người dùng từ session
    return response()->json(session('user'));
});



// ----------------Category routes----------------
route::get('/categories', [CategoryController::class, 'index']);
route::get('/categories/{id}', [CategoryController::class, 'show']);
route::post('/categories', [CategoryController::class, 'store']);
route::put('/categories/{id}', [CategoryController::class, 'update']);
route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

// ----------------Product routes----------------
route::get('/products', [ProductController::class, 'index']);
route::get('/products/{id}', [ProductController::class, 'show']);
route::post('/products', [ProductController::class, 'store']);
route::put('/products/{id}', [ProductController::class, 'update']);
route::delete('/products/{id}', [ProductController::class, 'destroy']);

// ----------------Auth routes----------------
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// ----------------User routes----------------
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

// ----------------Cart routes----------------
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart', [CartController::class, 'store']);
Route::put('/cart/{id}', [CartController::class, 'update']);
Route::delete('/cart/clear/{id}', [CartController::class, 'clear']);
// Route::delete('/cart/clear', [CartController::class, 'clear']);

// ----------------Order routes----------------
Route::get('orders', [OrderController::class, 'index']);
Route::get('orders/{id}', [OrderController::class, 'show']);
Route::put('orders/{id}/status', [OrderController::class, 'updateStatus']);
Route::post('/checkout', [OrderController::class, 'checkout']);

<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EmailVerificationNotificationController;
use App\Http\Controllers\EmailVerificationPromtController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifyEmailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/registration', [UserController::class, 'registration'])
    ->middleware(['role_guest', 'role_user_verified'])
    ->name('register-user');
Route::post('/registration', [UserController::class, 'create']);




//--------------Verification by Email-------------
Route::get('/email/verify', EmailVerificationPromtController::class)
    ->middleware('role_user')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['role_user', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', EmailVerificationNotificationController::class)
    ->middleware(['role_user', 'throttle:1.1'])
    ->name('verification.send');
//------------------------------------------------




Route::get('/login', [UserController::class, 'login'])
    ->middleware(['role_guest', 'role_user_verified'])
    ->name('login-user');
Route::post('/login', [UserController::class, 'authorizeUser']);
Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('role_user|role_admin')
    ->name('logout');


Route::middleware('role_user_verified')->group(function () {
    Route::get('/', [MainController::class, 'main'])
        ->name('main');
    Route::get('/catalog', [MainController::class, 'catalog'])
        ->name('catalog');
    Route::get('/category/{id}', [MainController::class, 'category'])
        ->name('category');
});


Route::get('/cart', [CartController::class, 'cart'])
    ->middleware('role_user_verified')
    ->name('cart');
Route::post('/addToCartProduct', [CartController::class, 'add'])
    ->name('addToCartProduct');
Route::post('/updateQuantityMinus', [CartController::class, 'updateQuantityMinus']);
Route::post('/deleteAll', [CartController::class, 'deleteAll']);

Route::get('/order', [OrderController::class, 'order'])
    ->middleware('role_user_verified')
    ->name('order');
Route::post('/addOrder', [OrderController::class, 'add'])
    ->name('addOrder');
Route::post('/order/pay/callback', [OrderController::class, 'callbackPay'])
    ->name('callback');


Route::middleware('role_admin')->group(function () {
    Route::get('admin-panel', [AdminController::class, 'admin'])
        ->name('admin-panel');
});



<?php

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
//    ->middleware('role_guest')
    ->name('register-user');
Route::post('/registration', [UserController::class, 'create']);




//--------------Verification by Email-------------
Route::get('/email/verify', EmailVerificationPromtController::class)
    ->middleware('role_user')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['role_user', 'signed', 'throttle:6.1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', EmailVerificationNotificationController::class)
    ->middleware(['role_user', 'throttle:6.1'])
    ->name('verification.send');
//------------------------------------------------




Route::get('/login', [UserController::class, 'login'])
    ->middleware('role_guest')
    ->name('login-user');
Route::post('/login', [UserController::class, 'authorizeUser']);
Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('role_user')
    ->name('logout');


Route::get('/', [MainController::class, 'main'])
    ->name('main');
Route::get('/catalog', [MainController::class, 'catalog'])
    ->name('catalog');
Route::get('/category/{id}', [MainController::class, 'category'])
    ->name('category');


Route::get('/cart', [CartController::class, 'cart'])
    ->middleware('auth')
    ->name('cart');
Route::post('/addToCartProduct', [CartController::class, 'add'])
    ->name('addToCartProduct');
Route::post('/updateQuantityMinus', [CartController::class, 'updateQuantityMinus'])
    ->middleware('auth');
Route::post('/deleteAll', [CartController::class, 'deleteAll'])
    ->middleware('auth');


Route::get('/order', [OrderController::class, 'order'])
    ->middleware('auth')
    ->name('order');
Route::post('/addOrder', [OrderController::class, 'add'])
    ->middleware('auth')
    ->name('addOrder');
Route::post('/order/pay/callback', [OrderController::class, 'callbackPay'])
    ->name('callback');



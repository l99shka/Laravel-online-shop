<?php

use App\Http\Controllers\CartProductController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
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
    ->middleware('guest')
    ->name('register-user');
Route::post('/registration', [UserController::class, 'create']);
Route::get('/login', [UserController::class, 'login'])
    ->middleware('guest')
    ->name('login-user');
Route::post('/login', [UserController::class, 'authorizeUser']);
Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


Route::get('/', [MainController::class, 'main'])
    ->name('main');
Route::get('/catalog', [MainController::class, 'catalog'])
    ->name('catalog');
Route::get('/category/{id}', [MainController::class, 'category'])
    ->name('category');


Route::get('/cartProduct', [CartProductController::class, 'cartProduct'])
    ->middleware('auth')
    ->name('cartProduct');
Route::post('/addToCartProduct', [CartProductController::class, 'addToCartProduct'])
    ->name('addToCartProduct');
Route::post('/updateQuantityPlus', [CartProductController::class, 'updateQuantityPlus'])
    ->middleware('auth');
Route::post('/updateQuantityMinus', [CartProductController::class, 'updateQuantityMinus'])
    ->middleware('auth');
Route::post('/deleteToCartProduct', [CartProductController::class, 'deleteToCartProduct'])
    ->middleware('auth');


Route::get('/orders', [OrderController::class, 'order'])
    ->middleware('auth')
    ->name('orders');
Route::post('/add-orders', [OrderController::class, 'addOrders'])
    ->middleware('auth')
    ->name('add-orders');
Route::post('/orders/pay/callback', [OrderController::class, 'callbackPay'])
    ->name('callback');



<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\MainController;
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
Route::get('/registration', [UserController::class, 'registration'])->middleware('guest')->name('register-user');
Route::post('/registration', [UserController::class, 'create']);
Route::get('/login', [UserController::class, 'login'])->middleware('guest')->name('login-user');
Route::post('/login', [UserController::class, 'authorizeUser']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/', [MainController::class, 'main'])->name('main');
Route::get('/catalog', [MainController::class, 'catalog'])->name('catalog');
Route::get('/category/{id}', [MainController::class, 'category'])->name('category');

Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::post('/updateQuantityPlus', [CartController::class, 'updateQuantityPlus']);
Route::post('/updateQuantityMinus', [CartController::class, 'updateQuantityMinus']);
Route::post('/deleteProduct', [CartController::class, 'deleteProduct']);



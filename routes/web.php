<?php

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
Route::get('/main', fn () => 'hello')->name('main');

Route::get('/registration', [UserController::class, 'registration'])->middleware('guest')->name('register-user');
Route::post('/registration', [UserController::class, 'create']);
Route::get('/login', [UserController::class, 'login'])->middleware('guest')->name('login-user');
Route::post('/login', [UserController::class, 'authorizeUser']);

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\UserController;

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

Route::get('/', [UserController::class, 'signin']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::prefix('/customer')->group(function () {
	Route::get('/', [CustomerController::class, 'index']);
	Route::get('/create', [CustomerController::class, 'create']);
	Route::get('/delete/{id}', [CustomerController::class, 'delete']);
	Route::get('/detail/{id}', [CustomerController::class, 'detail']);
	Route::get('/edit/{id}', [CustomerController::class, 'edit']);
	Route::post('/insert', [CustomerController::class, 'insert']);
	Route::post('/update', [CustomerController::class, 'update']);
});

Route::prefix('/car')->group(function () {
	Route::get('/', [CarController::class, 'index']);
	Route::get('/create', [CarController::class, 'create']);
	Route::get('/delete/{id}', [CarController::class, 'delete']);
	Route::get('/detail/{id}', [CarController::class, 'detail']);
	Route::get('/edit/{id}', [CarController::class, 'edit']);
	Route::post('/insert', [CarController::class, 'insert']);
	Route::post('/update', [CarController::class, 'update']);
});

Route::prefix('/rent')->group(function () {
	Route::get('/', [RentController::class, 'index']);
	Route::get('/create', [RentController::class, 'create']);
	Route::post('/check_car_availability_by_date', [RentController::class, 'check_car_availability_by_date']);
	Route::post('/get_nums_between_date', [RentController::class, 'get_nums_between_date']);
	Route::post('/insert', [RentController::class, 'insert']);
	Route::get('/detail/{id}', [RentController::class, 'detail']);
	Route::get('/edit/{id}', [RentController::class, 'edit']);
	Route::post('/update', [RentController::class, 'update']);
});

Route::prefix('/user')->group(function () {
	Route::get('/', [UserController::class, 'index']);
	Route::get('/signin', [UserController::class, 'signin']);
	Route::post('/login', [UserController::class, 'login']);
	Route::get('/logout', [UserController::class, 'logout']);
});
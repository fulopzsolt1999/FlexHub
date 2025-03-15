<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GymsController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\DaysController;
use App\Http\Controllers\AddressesController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/gyms', [GymsController::class, 'GetAllGyms']);

Route::get('/cities', [CitiesController::class, 'GetAllCities']);
Route::get('/cities/{id}', [CitiesController::class, 'GetCity']);

Route::get('/days', [DaysController::class, 'GetAllDays']);
Route::get('/days/{id}', [DaysController::class, 'GetDay']);

Route::get('/addresses', [AddressesController::class, 'GetAllAddress']);
Route::get('/addresses/{id}', [AddressesController::class, 'GetAddress']);

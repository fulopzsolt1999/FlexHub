<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GymsController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\DaysController;
use App\Http\Controllers\AddressesController;
use App\Http\Controllers\RestDayController;
use App\Http\Controllers\MuscleGroupController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\WorkoutPlanController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\AdminController;

Route::get('/admin/total-users', [AdminController::class, 'getTotalUsers']);
Route::get('/admin/workout-plan-stats', [AdminController::class, 'getWorkoutPlanStats']);
Route::get('/admin/monthly-stats', [AdminController::class, 'getMonthlyStats']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);

Route::get('/gyms', [GymsController::class, 'GetAllGyms']);

Route::get('/cities/{id}', [CitiesController::class, 'GetCity']);
Route::get('/cities', [CitiesController::class, 'GetAllCities']);

Route::get('/days', [DaysController::class, 'GetAllDays']);

Route::get('/addresses/{id}', [AddressesController::class, 'GetAddress']);
Route::get('/addresses', [AddressesController::class, 'GetAllAddress']);

Route::post('/rest-days/{userId}/{dayId}', [RestDayController::class, 'CreateRestDay']);
Route::delete('/rest-days/{userId}/{dayId}', [RestDayController::class, 'DeleteRestDay']);
Route::get('/rest-days/{userId}', [RestDayController::class, 'GetAllRestDays']);

Route::get('/muscle-groups', [MuscleGroupController::class, 'GetAll']);

Route::get('/exercises/{muscleGroupId}', [ExerciseController::class, 'GetByMuscleGroup']);

Route::post('/workout-plan/{userId}/{dayName}', [WorkoutPlanController::class, 'SaveWorkoutPlan']);
Route::delete('/workout-plan/{userId}/{dayId}', [WorkoutPlanController::class, 'DeleteWorkoutPlan']);
Route::get('/workout-plans/{userId}/{dayId}', [WorkoutPlanController::class, 'GetWorkoutPlans']);
Route::get('/workout-plan/{userId}/{dayId}', [WorkoutPlanController::class, 'GetWorkoutPlan']);

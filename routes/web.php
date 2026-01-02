<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\GuestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// эти маршруты нужны для CRUD операций с упражнениями и питанием
Route::resource('exercises', ExerciseController::class);
Route::resource('supplies', SupplyController::class);

// маршруты для гостевой регистрации и выхода
Route::get('/guest/register', [GuestController::class, 'register'])->name('guest.register');
Route::get('/guest/logout', [GuestController::class, 'logout'])->name('guest.logout');

Route::get('/guest/login', [GuestController::class, 'login'])->name('guest.login');
Route::post('/guest/login', [GuestController::class, 'authenticate'])->name('guest.authenticate');

Route::get('/guest/toggle-exercise/{id}', [GuestController::class, 'toggleExercise'])->name('guest.toggle.exercise');
Route::get('/guest/toggle-supply/{id}', [GuestController::class, 'toggleSupply'])->name('guest.toggle.supply');
Route::get('/my-plan', [GuestController::class, 'showPlan'])->name('guest.plan');
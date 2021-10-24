<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ArrangementController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TestController;

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

Route::get('test', [TestController::class, 'test'])->name('test');

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    // User

    Route::get('user', [AuthController::class, 'user'])->name('user');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Calendar

    Route::post('calendar/edit/{id}', [CalendarController::class, 'update']);
    Route::post('calendar/editMain/{id}', [CalendarController::class, 'updateMain']);
    Route::post('calendar/delete/{id}', [CalendarController::class, 'destroy']);

    Route::get('calendar/index', [CalendarController::class, 'index']);
    Route::post('calendar/create', [CalendarController::class, 'store']);

    Route::get('calendar/{id}', [CalendarController::class, 'show']);
    // Events

    Route::get('events', [EventController::class, 'index']);

    // Arrangements

    Route::post('arrangement/edit/{id}', [ArrangementController::class, 'update']);
    Route::post('arrangement/delete/{id}', [ArrangementController::class, 'destroy']);
    Route::post('arrangement/create', [ArrangementController::class, 'store']);
    Route::get('arrangement/{id}', [ArrangementController::class, 'show']);
    Route::get('arrangements', [ArrangementController::class, 'index']);

    // Reminders

    Route::post('reminder/edit/{id}', [ReminderController::class, 'update']);
    Route::post('reminder/delete/{id}', [ReminderController::class, 'destroy']);
    Route::post('reminder/create', [ReminderController::class, 'store']);
    Route::get('reminder/{id}', [ReminderController::class, 'show']);
    Route::get('reminders', [ReminderController::class, 'index']);

    // Tasks

    Route::post('task/edit/{id}', [TaskController::class, 'update']);
    Route::post('task/delete/{id}', [TaskController::class, 'destroy']);
    Route::post('task/create', [TaskController::class, 'store']);
    Route::get('task/{id}', [TaskController::class, 'show']);
    Route::get('tasks', [TaskController::class, 'index']);
});

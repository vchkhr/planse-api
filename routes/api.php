<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ArrangementController;
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

    Route::get('calendar/index', [CalendarController::class, 'index']);

    Route::post('calendar/create', [CalendarController::class, 'store']);

    Route::get('calendar/{id}', [CalendarController::class, 'show']);

    Route::post('calendar/update/{id}', [CalendarController::class, 'update']);
    Route::post('calendar/updateMain/{id}', [CalendarController::class, 'updateMain']);

    Route::post('calendar/delete/{id}', [CalendarController::class, 'destroy']);

    // Arrangement

    Route::get('calendar/{id}/arrangements', [ArrangementController::class, 'index']);
    Route::get('user/arrangements', [ArrangementController::class, 'indexUser']);

    Route::post('arrangement/create', [ArrangementController::class, 'store']);
});

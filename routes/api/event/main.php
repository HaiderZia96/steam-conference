<?php

use App\Http\Controllers\API\Event\EventController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['prefix' => 'event', 'middleware' => ['checkAppAuth','checkLogin']], function () {
    Route::get('/list', [EventController::class, 'eventList'])->withoutMiddleware('checkLogin');
    Route::get('/count/detail/', [EventController::class, 'allCounts']);
});

<?php

use App\Http\Controllers\API\Authentication\AuthController;
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


Route::group(['prefix' => 'auth', 'middleware' => ['checkAppAuth', 'checkLogin']], function () {
    Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware('checkLogin');
    Route::post('/logout', [AuthController::class, 'logout'])->withoutMiddleware('checkLogin');
    Route::get('/user/detail/{token}', [AuthController::class, 'userDetail']);
});

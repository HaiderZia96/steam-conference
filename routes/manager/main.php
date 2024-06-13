<?php

use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\profile\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/masterData/main.php';
require __DIR__ . '/steamPublication/main.php';
require __DIR__ . '/glimpse/main.php';
require __DIR__ . '/registration/main.php';
require __DIR__ . '/reports/main.php';
/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register backend web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the prefix "manager" middleware group. Now create something great!
|
*/
//Backend Routes
Route::group(['middleware' => ['auth', 'verified', 'xss', 'user.status', 'user.module:manager'], 'prefix' => 'manager', 'as' => 'manager.'], function () {
    //Profile
    Route::get('profile/{id}', [ProfileController::class, 'edit'])->name('profile');
    Route::put('profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile-image/{id}', [ProfileController::class, 'getImage'])->name('profile.get.image');
    //Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});



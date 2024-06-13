<?php

use App\Http\Controllers\Manager\SteamPublication\PublicationController;
use App\Http\Controllers\Manager\SteamPublication\PublicationTypeController;
use Illuminate\Support\Facades\Route;

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
Route::group(['middleware' => ['auth','verified','xss','user.status','user.module:manager'], 'prefix' => 'manager','as' => 'manager.'], function() {

    // Publication
    Route::resource('publication-type', PublicationTypeController::class);
    Route::get('get-publication-type',[PublicationTypeController::class,'getIndex'])->name('get.publication-type');
    Route::get('get-publication-type-select', [PublicationTypeController::class, 'getIndexPublicationTypeSelect'])->name('get.publication-type-select');
    Route::get('get-publication-type-activity/{id}',[PublicationTypeController::class,'getActivity'])->name('get.publication-type-activity');
    Route::get('get-publication-type-activity-log/{id}',[PublicationTypeController::class,'getActivityLog'])->name('get.publication-type-activity-log');
    Route::get('get-publication-type-activity-trash',[PublicationTypeController::class,'getTrashActivity'])->name('get.publication-type-activity-trash');
    Route::get('get-publication-type-activity-trash-log',[PublicationTypeController::class,'getTrashActivityLog'])->name('get.publication-type-activity-trash-log');

    // Publication
    Route::resource('publication', PublicationController::class);
    Route::get('get-publication',[PublicationController::class,'getIndex'])->name('get.publication');
    Route::get('get-publication-activity/{id}',[PublicationController::class,'getActivity'])->name('get.publication-activity');
    Route::get('get-publication-activity-log/{id}',[PublicationController::class,'getActivityLog'])->name('get.publication-activity-log');
    Route::get('get-publication-activity-trash',[PublicationController::class,'getTrashActivity'])->name('get.publication-activity-trash');
    Route::get('get-publication-activity-trash-log',[PublicationController::class,'getTrashActivityLog'])->name('get.publication-activity-trash-log');
    Route::get('download-publication/{id}',[PublicationController::class,'download'])->name('download-publication');

});



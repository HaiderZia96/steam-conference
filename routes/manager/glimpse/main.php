<?php

use App\Http\Controllers\Manager\Glimpse\GlimpseCategoryController;
use App\Http\Controllers\Manager\Glimpse\GlimpseController;
use App\Http\Controllers\Manager\Glimpse\GlimpseDayController;
use App\Http\Controllers\Manager\Glimpse\GlimpseYearController;
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

    // Glimpse Category
    Route::resource('glimpse-category', GlimpseCategoryController::class);
    Route::get('get-glimpse-category',[GlimpseCategoryController::class,'getIndex'])->name('get.glimpse-category');
    Route::get('get-glimpse-category-select', [GlimpseCategoryController::class, 'getIndexGlimpseCategorySelect'])->name('get.glimpse-category-select');
    Route::get('get-glimpse-category-activity/{id}',[GlimpseCategoryController::class,'getActivity'])->name('get.glimpse-category-activity');
    Route::get('get-glimpse-category-activity-log/{id}',[GlimpseCategoryController::class,'getActivityLog'])->name('get.glimpse-category-activity-log');
    Route::get('get-glimpse-category-activity-trash',[GlimpseCategoryController::class,'getTrashActivity'])->name('get.glimpse-category-activity-trash');
    Route::get('get-glimpse-category-activity-trash-log',[GlimpseCategoryController::class,'getTrashActivityLog'])->name('get.glimpse-category-activity-trash-log');

    // Glimpse Year
    Route::resource('glimpse-year', GlimpseYearController::class);
    Route::get('get-glimpse-year',[GlimpseYearController::class,'getIndex'])->name('get.glimpse-year');
    Route::get('get-glimpse-year-select', [GlimpseYearController::class, 'getIndexGlimpseYearSelect'])->name('get.glimpse-year-select');
    Route::get('get-glimpse-year-activity/{id}',[GlimpseYearController::class,'getActivity'])->name('get.glimpse-year-activity');
    Route::get('get-glimpse-year-activity-log/{id}',[GlimpseYearController::class,'getActivityLog'])->name('get.glimpse-year-activity-log');
    Route::get('get-glimpse-year-activity-trash',[GlimpseYearController::class,'getTrashActivity'])->name('get.glimpse-year-activity-trash');
    Route::get('get-glimpse-year-activity-trash-log',[GlimpseYearController::class,'getTrashActivityLog'])->name('get.glimpse-year-activity-trash-log');

    // Glimpse Day
    Route::resource('glimpse-day', GlimpseDayController::class);
    Route::get('get-glimpse-day',[GlimpseDayController::class,'getIndex'])->name('get.glimpse-day');
    Route::get('get-glimpse-day-select', [GlimpseDayController::class, 'getIndexGlimpseDaySelect'])->name('get.glimpse-day-select');
    Route::get('get-glimpse-day-activity/{id}',[GlimpseDayController::class,'getActivity'])->name('get.glimpse-day-activity');
    Route::get('get-glimpse-day-activity-log/{id}',[GlimpseDayController::class,'getActivityLog'])->name('get.glimpse-day-activity-log');
    Route::get('get-glimpse-day-activity-trash',[GlimpseDayController::class,'getTrashActivity'])->name('get.glimpse-day-activity-trash');
    Route::get('get-glimpse-day-activity-trash-log',[GlimpseDayController::class,'getTrashActivityLog'])->name('get.glimpse-day-activity-trash-log');

    // Glimpse
    Route::resource('glimpse', GlimpseController::class);
    Route::get('get-glimpse',[GlimpseController::class,'getIndex'])->name('get.glimpse');
    Route::get('get-image-glimpse/{id}',[GlimpseController::class,'getGlimpseImage'])->name('get-image.glimpse');
    Route::get('get-glimpse-activity/{id}',[GlimpseController::class,'getActivity'])->name('get.glimpse-activity');
    Route::get('get-glimpse-activity-log/{id}',[GlimpseController::class,'getActivityLog'])->name('get.glimpse-activity-log');
    Route::get('get-glimpse-activity-trash',[GlimpseController::class,'getTrashActivity'])->name('get.glimpse-activity-trash');
    Route::get('get-glimpse-activity-trash-log',[GlimpseController::class,'getTrashActivityLog'])->name('get.glimpse-activity-trash-log');
    Route::get('download-glimpse/{id}',[GlimpseController::class,'download'])->name('download-glimpse');


});



<?php

use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\RegistrationController;
use App\Http\Controllers\User\PaperSubmissionController;
use App\Http\Controllers\User\profile\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register backend web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the prefix "admin" middleware group. Now create something great!
|
*/


//Backend Routes
Route::group(['middleware' => ['auth', 'verified', 'xss', 'user.status', 'user.module:user'], 'prefix' => 'user', 'as' => 'user.'], function () {
    //Profile
    Route::get('profile/{id}', [ProfileController::class, 'edit'])->name('profile');
    Route::put('profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile-image/{id}', [ProfileController::class, 'getImage'])->name('profile.get.image');

    //Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('user-registration', [RegistrationController::class, 'index'])->name('user-registration');
    Route::get('get-user-registration', [RegistrationController::class, 'getIndex'])->name('get.user-registration');
    Route::get('get-user-registration-status/{id}', [RegistrationController::class, 'editStatus'])->name('get.user-registration-status');

    // Paper Submission Route
    Route::resource('paper-submission', PaperSubmissionController::class);
    Route::get('get-paper-submission', [PaperSubmissionController::class, 'getIndex'])->name('get.paper-submission');
    Route::get('get-registration-status-select', [PaperSubmissionController::class, 'getRegistrationStatusIndex'])->name('get.registration-status-select');
    Route::get('get-paper-submission-status/{id}', [PaperSubmissionController::class, 'editStatus'])->name('get.paper-submission-status');
    Route::put('get-paper-submission-update-status/{id}', [PaperSubmissionController::class, 'updateStatus'])->name('get.paper-submission-update-status');
    Route::get('get-paper-submission-activity/{id}', [PaperSubmissionController::class, 'getActivity'])->name('get.paper-submission-activity');
    Route::get('get-paper-submission-activity-log/{id}', [PaperSubmissionController::class, 'getActivityLog'])->name('get.paper-submission-activity-log');
    Route::get('get-paper-submission-activity-trash', [PaperSubmissionController::class, 'getTrashActivity'])->name('get.paper-submission-activity-trash');
    Route::get('get-paper-submission-activity-trash-log', [PaperSubmissionController::class, 'getTrashActivityLog'])->name('get.paper-submission-activity-trash-log');
    Route::get('paper-file/{id}',[PaperSubmissionController::class,'getImage'])->name('paper-file');

    Route::get('download-voucher/{id}', [RegistrationController::class, 'voucher'])->name('download-voucher');
    Route::get('download-gate-pass/{id}', [RegistrationController::class, 'gatePass'])->name('download-gate-pass');
    Route::get('download-certificate/{id}', [RegistrationController::class, 'certificate'])->name('download-certificate');
    Route::put('upload-voucher/{id}', [RegistrationController::class, 'upload'])->name('upload-voucher');
    Route::get('voucher-image/{id}',[RegistrationController::class,'getImage'])->name('get.voucher-image');



});



<?php

use App\Http\Controllers\Manager\Registration\PaperSubmissionController;
use App\Http\Controllers\Manager\Registration\UserRegistrationController;
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
Route::group(['middleware' => ['auth', 'verified', 'xss', 'user.status', 'user.module:manager'], 'prefix' => 'manager', 'as' => 'manager.'], function () {

    // User Registration
    Route::resource('conference-year/{yid}/detail/user-registration', UserRegistrationController::class, ['as' => 'conference-year']);
    Route::get('conference-year/{yid}/detail', [UserRegistrationController::class, 'sessionDetail'])->name('session-detail');
    Route::get('conference-year/{yid}/detail/candidate-status/{id}', [UserRegistrationController::class, 'candidateStatus'])->name('candidate-status');
    Route::get('get-user-registration', [UserRegistrationController::class, 'getIndex'])->name('get.user-registration');
//    Route::get('get-user-registration-select', UserRegistrationController::class, 'getIndexSelect'])->name('get.user-registration-select');
    Route::get('conference-year/{yid}/detail/get-user-registration-status/{id}', [UserRegistrationController::class, 'editStatus'])->name('get.user-registration-status');
    Route::put('conference-year/{yid}/detail/get-user-registration-update-status/{id}', [UserRegistrationController::class, 'updateStatus'])->name('get.user-registration-update-status');
    Route::get('conference-year/{yid}/detail/get-user-registration-certificate-status/{id}', [UserRegistrationController::class, 'editCertificateStatus'])->name('get.user-registration-certificate-status');
    Route::put('conference-year/{yid}/detail/get-user-registration-update-certificate-status/{id}', [UserRegistrationController::class, 'updateCertificateStatus'])->name('get.user-registration-update-certificate-status');
    Route::get('conference-year/{yid}/detail/get-user-registration-activity/{id}', [UserRegistrationController::class, 'getActivity'])->name('get.user-registration-activity');
    Route::get('get-user-registration-activity-log/{id}', [UserRegistrationController::class, 'getActivityLog'])->name('get.user-registration-activity-log');
    Route::get('conference-year/{yid}/detail/get-user-registration-activity-trash', [UserRegistrationController::class, 'getTrashActivity'])->name('get.user-registration-activity-trash');
    Route::get('get-user-registration-activity-trash-log', [UserRegistrationController::class, 'getTrashActivityLog'])->name('get.user-registration-activity-trash-log');
    Route::get('get-user-registration-conference-year-select', [UserRegistrationController::class, 'getSessionIndexSelect'])->name('get.user-registration-conference-year-select');
    Route::get('user-registration-detail/{id}', [UserRegistrationController::class, 'detail', 'as' => 'conference-year'])->name('user-registration-detail');

    // download & upload voucher
    Route::put('conference-year/{yid}/detail/upload-voucher/{id}', [UserRegistrationController::class, 'upload'])->name('upload-voucher');
    Route::get('download-voucher/{id}', [UserRegistrationController::class, 'voucher'])->name('download-voucher');
    Route::get('download-certificate/{id}', [UserRegistrationController::class, 'certificate'])->name('download-certificate');
    Route::get('download-gate-pass/{id}', [UserRegistrationController::class, 'gatePass'])->name('download-gate-pass');
    Route::get('voucher-image/{id}', [UserRegistrationController::class, 'getImage'])->name('get.voucher-image');


    // Abstract Submission
    Route::resource('conference-year/{yid}/detail/user-registration/{uid}/paper-submission', PaperSubmissionController::class, ['as' => 'conference-year.user-registration']);
    Route::get('get-paper-submission', [PaperSubmissionController::class, 'getIndex'])->name('get.paper-submission');
//    Route::get('get-paper-submission-select', PaperSubmissionController::class, 'getIndexSelect'])->name('get.paper-submission-select');
    Route::get('conference-year/{yid}/user-registration/{uid}/get-paper-submission-status/{id}', [PaperSubmissionController::class, 'editStatus'])->name('get.paper-submission-status');
    Route::put('conference-year/{yid}/user-registration/{uid}/get-paper-submission-update-status/{id}', [PaperSubmissionController::class, 'updateStatus'])->name('get.paper-submission-update-status');
    Route::get('conference-year/{yid}/user-registration/{uid}/get-paper-submission-activity/{id}', [PaperSubmissionController::class, 'getActivity'])->name('get.paper-submission-activity');
    Route::get('get-paper-submission-activity-log/{id}', [PaperSubmissionController::class, 'getActivityLog'])->name('get.paper-submission-activity-log');
    Route::get('conference-year/{yid}/user-registration/{uid}/get-paper-submission-activity-trash', [PaperSubmissionController::class, 'getTrashActivity'])->name('get.paper-submission-activity-trash');
    Route::get('get-paper-submission-activity-trash-log', [PaperSubmissionController::class, 'getTrashActivityLog'])->name('get.paper-submission-activity-trash-log');
    Route::get('paper-submission-file/{id}', [PaperSubmissionController::class, 'getImage'])->name('paper-submission-file');
});



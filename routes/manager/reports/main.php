<?php

use App\Http\Controllers\Manager\Reports\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the prefix "admin" middleware group. Now create something great!
|
*/
//Admin Routes

Route::group(['middleware' => ['auth', 'verified', 'xss',  'user.status', 'user.module:manager'], 'prefix' => 'manager', 'as' => 'manager.'], function () {

    //Candidate
    Route::get('conference-year/{yid}/reports/candidate/detail', [ReportController::class, 'candidateDetail'])->name('report.candidate-detail');
    Route::get('conference-year/{yid}/get/candidate/detail', [ReportController::class, 'getCandidateDetail'])->name('report.get.candidate-detail');
    Route::get('get-register-candidate', [ReportController::class, 'getRegisterCandidate'])->name('get.register-candidate');

 // Registration
 Route::get('conference-year/{yid}/reports/registration', [ReportController::class, 'registrationDetail'])->name('report.registration');
 Route::get('conference-year/{yid}/get/registration', [ReportController::class, 'getRegistrationDetail'])->name('report.get.registration');
});



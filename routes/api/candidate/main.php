<?php
use App\Http\Controllers\API\Candidate\CandidateController;
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


Route::group(['prefix' => 'candidate', 'middleware' => ['checkAppAuth', 'checkLogin']], function () {
    Route::get('/register/list', [CandidateController::class, 'registerList']);
    Route::get('/scan/{qrCode}', [CandidateController::class, 'scanCandidate']);
    Route::get('/profile/{cid}', [CandidateController::class, 'getImage'])->name('profile-image');
    Route::get('/attendance/mark/{qrCode}', [CandidateController::class, 'attendanceMark']);
    Route::get('/attendance/history/{qrCode}', [CandidateController::class, 'attendanceHistory']);
    Route::get('/attendance/detail/{qrCode}', [CandidateController::class, 'attendanceDetail']);
    Route::get('count/detail', [CandidateController::class, 'totalCounts']);

    Route::get('/payment/verification', [CandidateController::class, 'paymentStatus']);
});

<?php

use App\Http\Controllers\Front\GlimpseController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PublicationController;
use App\Http\Controllers\Front\RegistrationController;
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
//Frontend Routes

Route::get('home', [HomeController::class, 'index'])->name('front.home');
Route::get('about-us', [HomeController::class, 'aboutUs'])->name('front.about-us');
Route::get('attendees',[HomeController::class, 'attendees'])->name('front.attendees');
Route::get('conference-track',[HomeController::class, 'conferenceTrack'])->name('front.conference-track');
Route::get('conference-chairs',[HomeController::class, 'conferenceChairs'])->name('front.conference-chairs');
Route::get('panelists',[HomeController::class, 'panelists'])->name('front.panelists');
// Route::get('date',[HomeController::class, 'date'])->name('front.date');
Route::get('paper-submission', [HomeController::class, 'paperSubmission'])->name('front.paper-submission');
Route::get('contact-us', [HomeController::class, 'contactUs'])->name('front.contact');
//Route::get('publication', [HomeController::class, 'publication'])->name('front.publication');
Route::get('registration', [RegistrationController::class, 'index'])->name('front.registration');

Route::post('registration-store', [RegistrationController::class, 'store'])->name('registration-store');
Route::get('get-countries-select', [RegistrationController::class, 'getCountryIndexSelect'])->name('get.countries-select');
Route::get('get-states-select', [RegistrationController::class, 'getStateIndexSelect'])->name('get.states-select');
Route::get('get-cities-select', [RegistrationController::class, 'getCityIndexSelect'])->name('get.cities-select');
Route::get('get-registration-type-select', [RegistrationController::class, 'getIndexRegistrationTypeSelect'])->name('get.registration-type-select');
Route::get('get-payment-type-select', [RegistrationController::class, 'getIndexPaymentTypeSelect'])->name('get.payment-type-select');

// Publication
Route::resource('publication', PublicationController::class);
Route::get('get-publication', [PublicationController::class, 'getPublication'])->name('get.publication');

// Glimpse
Route::resource('glimpse', GlimpseController::class);
Route::get('get-image-glimpse/{id}', [GlimpseController::class, 'getGlimpseImage'])->name('get-image.glimpse');



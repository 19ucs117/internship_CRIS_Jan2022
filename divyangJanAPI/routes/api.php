<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('auth')->group(function () {
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('/me', [\App\Http\Controllers\AuthController::class, 'me']);
    Route::post('/isLogin', [\App\Http\Controllers\AuthController::class, 'isLogin']);
});


Route::post('/registrationPartOne', [\App\Http\Controllers\RegistrationController::class, 'submitRegistrationPartOne']);

Route::get('/read_RailwayConcessionCertificate/{handicapped_person_id}', [\App\Http\Controllers\PartThreeReadController::class, 'readRailway_concession_certificate']);
Route::get('/read_DisabilityCertificate/{handicapped_person_id}', [\App\Http\Controllers\PartThreeReadController::class, 'readDisability_or_handicapped_certificate']);
Route::get('/read_AgeCertificate/{handicapped_person_id}', [\App\Http\Controllers\PartThreeReadController::class, 'readAge_certificate']);
Route::get('/read_AadhaarCard/{handicapped_person_id}', [\App\Http\Controllers\PartThreeReadController::class, 'readAadhaar_card']);
Route::get('/read_AddressProof/{handicapped_person_id}', [\App\Http\Controllers\PartThreeReadController::class, 'readAddress_proof']);
Route::get('/read_PassportsizePhoto/{handicapped_person_id}', [\App\Http\Controllers\PartThreeReadController::class, 'readPassportsize_photo']);

Route::middleware('auth')->group(function () {
  Route::post('/registrationPartTwo', [\App\Http\Controllers\RegistrationController::class, 'submitRegistrationPartTwo']);
  Route::post('/registrationPartThree', [\App\Http\Controllers\RegistrationController::class, 'submitRegistrationPartThree']);
  Route::get('/READregistrationPartTwo/{handicapped_person_id}', [\App\Http\Controllers\RegistrationController::class, 'readRegistrationFormPartTwo']);
  Route::get('/READregistrationPartThree/{handicapped_person_id}', [\App\Http\Controllers\RegistrationController::class, 'readRegistrationFormPartThree']);
  Route::put('/UPDATEregistrationPartOne/{handicapped_person_id}', [\App\Http\Controllers\RegistrationController::class, 'updateRegistrationPartOne']);
  Route::put('/UPDATEregistrationPartTwo/{handicapped_person_id}', [\App\Http\Controllers\RegistrationController::class, 'updateRegistrationPartTwo']);
  Route::post('/update_RailwayConcessionCertificate', [\App\Http\Controllers\RegistrationController::class, 'updateRailway_concession_certificate']);
  Route::post('/update_DisabilityCertificate', [\App\Http\Controllers\RegistrationController::class, 'updateDisability_or_handicapped_certificate']);
  Route::post('/update_AgeCertificate', [\App\Http\Controllers\RegistrationController::class, 'updateAge_certificate']);
  Route::post('/update_AadhaarCard', [\App\Http\Controllers\RegistrationController::class, 'updateAadhaar_card']);
  Route::post('/update_AddressProof', [\App\Http\Controllers\RegistrationController::class, 'updateAddress_proof']);
  Route::post('/update_PassportsizePhoto', [\App\Http\Controllers\RegistrationController::class, 'updatePassportsize_photo']);
  Route::get('/registartionCOMPLETION', [\App\Http\Controllers\RegistrationController::class, 'CompletionOfRegistration']);
});

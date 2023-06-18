<?php

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});
Route::controller(VerificationController::class)->group(function () {
	Route::get('/verify-email/{token}', 'verifyEmail')->name('verification.verify');
	Route::get('/password-update/{token}', 'passwordReset');
	Route::get('/update-email/{email}', 'updateEmail');
});
Route::controller(GoogleAuthController::class)->group(function () {
	Route::get('auth/redirect', 'redirect');
	Route::get('auth/google/callback', 'callback');
});
Route::view('/', 'swagger')->name('landing');

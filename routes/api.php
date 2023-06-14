<?php

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});
Route::group(['controller' => UserController::class], function () {
	Route::post('/register', 'register');
	Route::post('/login', 'login');
	Route::post('/logout', 'logout');
	Route::post('/upload-avatar', 'upload');
	Route::put('/update-user/{user}', 'update_user');
});
Route::group(['controller'=>GoogleAuthController::class], function () {
	Route::get('auth/redirect', 'redirect');
	Route::get('auth/google/callback', 'callback');
});
Route::controller(VerificationController::class)->group(function () {
	Route::get('/verify-email/{token}', 'verifyEmail');
	Route::get('/update-email/{email}', 'updateEmail');
	Route::get('/password-update/{token}', 'passwordReset');
});

Route::group(['controller'=>PasswordResetController::class], function () {
	Route::post('/forgot-password', 'send_reset_password_mail')->name('password.email');
	Route::put('/password-update/{token}', 'reset_password')->name('password.reset');
	Route::put('/update-password', 'password_update');
});

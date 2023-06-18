<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\QuoteController;
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
Route::controller(UserController::class)->group(function () {
	Route::post('/upload-avatar', 'upload');
	Route::put('/update-user/{user}', 'update_user');
});
Route::controller(AuthController::class)->group(function () {
	Route::post('/register', 'register');
	Route::post('/login', 'login');
	Route::post('/logout', 'logout');
});
Route::controller(GoogleAuthController::class)->group(function () {
	Route::get('auth/redirect', 'redirect');
	Route::get('auth/google/callback', 'callback');
});
Route::controller(VerificationController::class)->group(function () {
	Route::get('/verify-email/{token}', 'verifyEmail');
	Route::get('/update-email/{email}', 'updateEmail');
	Route::get('/password-update/{token}', 'passwordReset');
});

Route::controller(PasswordResetController::class)->group(function () {
	Route::post('/forgot-password', 'send_reset_password_mail')->name('password.email');
	Route::put('/password-update/{token}', 'reset_password')->name('password.reset');
	Route::put('/update-password', 'password_update');
});

Route::controller(QuoteController::class)->group(function () {
	Route::get('/quotes', 'index');
	Route::post('/add-quote', 'store');
});
Route::controller(MovieController::class)->group(function () {
	Route::get('/movies', 'get_movies');
});

Route::controller(LikeController::class)->group(function () {
	Route::post('/addLike', 'create');
});
Route::controller(CommentController::class)->group(function () {
	Route::post('/add-comment', 'create');
});

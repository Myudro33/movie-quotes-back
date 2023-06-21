<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailVerificationController;
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
	Route::post('/update-user/{user}', 'update')->name('update.user');
});
Route::controller(AuthController::class)->group(function () {
	Route::post('/register', 'register')->name('register.user');
	Route::post('/login', 'login')->name('login.user');
	Route::post('/logout', 'logout')->name('logout.user');
});
Route::controller(GoogleAuthController::class)->group(function () {
	Route::get('auth/redirect', 'redirect');
	Route::get('auth/google/callback', 'callback');
});
Route::controller(EmailVerificationController::class)->group(function () {
	Route::get('/verify-email/{token}', 'verifyEmail');
	Route::get('/password-update/{token}', 'passwordReset');
	Route::post('/update-email/{token}', 'updateEmail');
});

Route::controller(PasswordResetController::class)->group(function () {
	Route::post('/forgot-password/{user}', 'send_reset_password_mail')->name('reset_password.email');
	Route::put('/password-update/{token}', 'update')->name('password.reset')->name('password.update');
});

Route::controller(QuoteController::class)->group(function () {
	Route::get('/quotes', 'index')->name('get.quotes');
	Route::post('/add-quote', 'store')->name('add.quote');
});
Route::controller(MovieController::class)->group(function () {
	Route::get('/movies', 'index')->name('get.movies');
});

Route::controller(LikeController::class)->group(function () {
	Route::post('/addLike', 'create')->name('create.like');
	Route::post('/deleteLike', 'destroy')->name('destroy.like');
});
Route::controller(CommentController::class)->group(function () {
	Route::post('/add-comment', 'create')->name('create.comment');
});

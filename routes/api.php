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
	Route::post('/update-user/{user}', 'update')->name('user.update');
});
Route::controller(AuthController::class)->group(function () {
	Route::post('/register', 'register')->name('user.register');
	Route::post('/login', 'login')->name('user.login');
	Route::post('/logout', 'logout')->name('user.logout');
});
Route::controller(GoogleAuthController::class)->group(function () {
	Route::get('auth/redirect', 'redirect')->name('user.google_redirect');
	Route::get('auth/google/callback', 'callback')->name('user.google_auth');
});
Route::controller(EmailVerificationController::class)->group(function () {
	Route::get('/verify-email/{token}', 'verifyEmail')->name('user.email_verify');
	Route::get('/password-update/{token}', 'passwordReset')->name('user.password_update');
	Route::post('/update-email/{token}', 'updateEmail')->name('user.email_update');
});

Route::controller(PasswordResetController::class)->group(function () {
	Route::post('/forgot-password/{user}', 'send_reset_password_mail')->name('user.password_change_request');
	Route::put('/password-update/{token}', 'update')->name('password.reset')->name('user.password_update');
});

Route::controller(QuoteController::class)->group(function () {
	Route::get('/quotes', 'index')->name('quote.get_quotes');
	Route::post('/quote', 'store')->name('quote.store');
});
Route::controller(MovieController::class)->group(function () {
	Route::get('/movies', 'index')->name('movie.get_movies');
	Route::get('/movies/{movie}', 'get')->name('movie.get_single_movie');
	Route::post('/movie', 'store')->name('movie.store_movie');
	Route::post('/movieUpdate/{movie}', 'update')->name('movie.update');
	Route::delete('/deleteMovie/{movie}', 'delete')->name('movie.delete');
});

Route::controller(LikeController::class)->group(function () {
	Route::post('/addLike', 'create')->name('like.create');
	Route::delete('/deleteLike/{like}', 'delete')->name('like.delete');
});
Route::controller(CommentController::class)->group(function () {
	Route::post('/comment', 'create')->name('comment.create');
});

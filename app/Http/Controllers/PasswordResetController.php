<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
	public function send_reset_password_mail(User $user)
	{
		$token = Password::createToken($user);
		Mail::send('emails.reset_password', ['token' => $token], function ($message) use ($user) {
			$message->to($user->email);
			$message->subject('Password Reset');
		});
		return response()->json(['message'=>'email sent successfully'], 200);
	}

	public function update(PasswordUpdateRequest $request)
	{
		$status = Password::reset(
			$request->validated(),
			function (User $user, string $password) {
				$user->forceFill([
					'password' => $password,
				]);
				$user->verification_token = null;
				$user->save();
				event(new PasswordReset($user));
			}
		);
		return $status === Password::PASSWORD_RESET
				? response()->json(['message'=>'password updated'], 200)
				: response()->json(['message'=>'error'], 401);
	}
}

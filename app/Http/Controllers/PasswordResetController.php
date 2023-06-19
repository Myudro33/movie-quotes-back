<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
	public function send_reset_password_mail(User $user)
	{
		$token = Str::random(40);
		$status = Password::sendResetLink(
			['email'=>$user->email, 'token'=>$token]
		);

		return $status === Password::RESET_LINK_SENT
			? response()->json(['message'=>'email sent successfully'], 200)
				: response()->json(['message'=>'error'], 401);
	}

	public function update(Request $request)
	{
		$status = Password::reset(
			$request->only('email', 'password', 'token'),
			function (User $user, string $password) {
				$user->forceFill([
					'password' => $password,
				]);
				$user->save();
				event(new PasswordReset($user));
			}
		);
		return $status === Password::PASSWORD_RESET
				? response()->json(['message'=>'password updated'], 200)
				: response()->json(['message'=>'error'], 401);
	}
}

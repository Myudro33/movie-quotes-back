<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VerificationController extends Controller
{
	public function verifyEmail($token)
	{
		$user = User::where('verification_token', $token)->firstOrFail();
		$user->email_verified_at = now();
		$user->verification_token = null;
		$user->save();
		$link = 'http://localhost:5174' . '?stage=verified';
		return redirect($link);
	}

	public function passwordReset($token)
	{
		$plainTextToken = $token;
		$passwordResetTokens = DB::table('password_reset_tokens')->get();
		foreach ($passwordResetTokens as $passwordResetToken) {
			if (Hash::check($plainTextToken, $passwordResetToken->token)) {
				$user = DB::table('users')->where('email', $passwordResetToken->email)->first();
				return redirect('http://localhost:5174?' . 'email=' . $user->email . '&token=' . $token . '&stage=reset-email-verified');
				break;
			}
		}
	}

	public function updateEmail($request)
	{
		$input = $request;
		$input_array = explode('&', $input);
		$user = User::where('email', $input_array[0])->first();
		$user->email = $input_array[1];
		$user->save();
		$link = 'http://localhost:5174/feed' . '?stage=email-updated';
		return redirect($link);
	}
}

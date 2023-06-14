<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

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
		$token = $token;
		$email = DB::table('password_reset_tokens')
			->where('token', $token)
			->first()->email;
		return redirect('http://localhost:5174?' . 'email=' . $email . '&token=' . $token . '&stage=reset-email-verified');
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

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
	public function redirect()
	{
		return Socialite::driver('google')->stateless()->redirect();
	}

	public function callback()
	{
		$google_user = Socialite::driver('google')->stateless()->user();
		$user = User::where('google_id', $google_user->getId())->first();
		if (!$user) {
			$user = User::create([
				'username'         => $google_user->getName(),
				'email'            => $google_user->getEmail(),
				'google_id'        => $google_user->getId(),
				'avatar'           => $google_user->getAvatar(),
			]);
		}
		Auth::login($user);
		return redirect(env('GOOGLE_AUTH_REDIRECT'));
	}
}

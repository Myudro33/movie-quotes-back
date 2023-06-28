<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
	public function redirect(): JsonResponse
	{
		$url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
		return response()->json(['message'=>'success', 'url'=>$url], 200);
	}

	public function callback(): JsonResponse
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
		return response()->json(['message'=>'success', 'user'=>$user], 200);
	}
}

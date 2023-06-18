<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Mail\VerifyUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
	public function register(UserRegisterRequest $request)
	{
		$user = User::create($request->validated());
		Mail::to($user->email)
			->send(new VerifyUser($user));
		return response()->json(['user'=>$user, 'message'=>'user created successfully'], 201);
	}

	public function login(UserLoginRequest $request)
	{
		$user = User::where('email', $request->validated('username'))
		->orWhere('username', $request->validated('username'))
		->first();
		if ($user) {
			if ($user->email_verified_at !== null) {
				if (Hash::check($request->validated('password'), $user->password)) {
					if (Auth::attempt(['username' => $request->username, 'password' => $request->validated('password')], (bool) $request->has('remember'))) {
						return response()->json(['message'=>'success', 'user'=>$user], 200);
					} elseif (Auth::attempt(['email' => $request->username, 'password' => $request->validated('password')], (bool) $request->has('remember'))) {
						return response()->json(['message'=>'success', 'user'=>$user], 200);
					}
				}
			} else {
				return response()->json(['message' => __('login.must_verify')], 401);
			}
		}
		return response()->json(['message' => __('login.wrong_username_or_password')], 401);
	}

	public function logout()
	{
		Auth::guard('web')->logout();

		return response()->json(['data' => 'User Logout successfully.'], 200);
	}
}

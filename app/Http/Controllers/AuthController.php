<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Mail\VerifyUser;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
	public function register(UserRegisterRequest $request): JsonResponse
	{
		$user = User::create($request->validated());
		Mail::to($user->email)
			->send(new VerifyUser($user));
		return response()->json(['user'=>$user, 'message'=>'user created successfully'], 201);
	}

	public function login(UserLoginRequest $request): JsonResponse
	{
		$user = User::where('email', $request->validated('username'))
		->orWhere('username', $request->validated('username'))
		->first();
		if ($user) {
			if (Auth::attempt(['username' => $user->username, 'password' => $request->validated('password')], (bool) $request->has('remember'))) {
				return response()->json(['message'=>'success', 'user'=>$user], 200);
			} elseif (Auth::attempt(['email' => $user->email, 'password' => $request->validated('password')], (bool) $request->has('remember'))) {
				return response()->json(['message'=>'success', 'user'=>$user], 200);
			}
		}
		return response()->json(['message' => __('login.wrong_username_or_password')], 401);
	}

	public function logout(): JsonResponse
	{
		Auth::guard('web')->logout();

		return response()->json(['data' => 'User Logout successfully.'], 200);
	}
}

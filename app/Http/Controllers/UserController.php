<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Mail\VerifyUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
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

	public function update_user(Request $request, User $user)
	{
		if ($request->has('username') && $request->username) {
			$user->username = $request->username;
		}
		if ($request->has('email') && $request->email !== $user->email) {
			$new_email_user = User::where('email', $request->email)->first();
			if ($new_email_user) {
				return response()->json(['message'=>'email already used'], 401);
			}
			Mail::send('email.email-update', ['email' => $user->email, 'new_email'=>$request->email], function ($message) use ($request) {
				$message->to($request->email);
				$message->subject('Email Update');
			});
			return response()->json(['email'=>$user->email, 'new_email'=>$request->email, 'message'=>'email sent successfully'], 200);
		}
		if ($request->has('newPassword') && $request->newPassword) {
			if ($request->confirmPassword === $request->newPassword) {
				$user->password = $request->newPassword;
			} else {
				return response()->json(['message'=>''], 401);
			}
		}
		$user->verification_token = null;
		$user->save();
		return response()->json(['user'=>$user, 'message'=>'success'], 200);
	}

	public function upload(Request $request)
	{
		if ($request->hasFile('avatar')) {
			$avatar = $request->file('avatar');
			$filename = $avatar->getClientOriginalName();
			$avatar->storeAs('avatars', $filename, 'public');

			$user = User::where('email', $request->email)->first();
			$user->avatar = asset('storage/avatars/' . $filename);
			$user->save();

			return response()->json(['avatar'=>$user->avatar], 200);
		}
		return response()->json(['message' => 'No file uploaded'], 401);
	}

	public function logout()
	{
		Auth::guard('web')->logout();

		return response()->json(['data' => 'User Logout successfully.'], 200);
	}
}

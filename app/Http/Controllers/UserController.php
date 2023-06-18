<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
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
}

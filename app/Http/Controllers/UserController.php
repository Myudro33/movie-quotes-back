<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
	public function update(Request $request, User $user)
	{
		if ($request->hasFile('avatar')) {
			$avatar = $request->file('avatar');
			$filename = $avatar->getClientOriginalName();
			$avatar->storeAs('avatars', $filename, 'public');
			$user = User::where('email', $request->email)->first();
			$user->avatar = asset('storage/avatars/' . $filename);
			$user->save();

			return response()->json(['avatar'=>$user->avatar], 200);
		} else {
			$user->username = $request->username;
			$email = $request->email;
			if ($email !== $user->email && $request->has('email')) {
				$new_email_user = User::where('email', $email)->first();
				if ($new_email_user) {
					return response()->json(['message'=>'email already used'], 401);
				}
				$token = Str::random(40);
				$user->verification_token = $token;
				$user->save();
				Mail::send('emails.email-update', ['token'=>$token, 'email' => $user->email, 'new_email'=>$email], function ($message) use ($user) {
					$message->to($user->email);
					$message->subject('Email Update');
				});
				return response()->json(['email'=>$user->email, 'new_email'=>$email, 'message'=>'email sent successfully'], 200);
			}
			if ($request->has('password')) {
				$user->password = $request->password;
			}
			$user->save();
		}

		return response()->json(['user'=>$user, 'message'=>'success'], 200);
	}
}

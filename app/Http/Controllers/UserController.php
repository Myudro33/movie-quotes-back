<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
	public function update(UserUpdateRequest $request, User $user)
	{
		if ($request->hasFile('avatar')) {
			$request->validate(['avatar'=>'image|mimes:png,jpg']);
			if ($user->avatar) {
				$avatarPath = public_path('storage/avatars/' . $user->avatar);
				if (File::exists($avatarPath)) {
					File::delete($avatarPath);
				}
			}
			$avatar = $request->file('avatar');
			$avatarPath = $avatar->store('public/avatars');
			$user->avatar = basename($avatarPath);
			$user->save();
			return response()->json(['avatar'=>$user->avatar], 200);
		} else {
			if ($request->has('username')) {
				$user->username = $request->username;
			}
			$email = $request->email;
			if ($email !== $user->email) {
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
			return response()->json(['user'=>$user, 'message'=>'success'], 200);
		}
	}
}

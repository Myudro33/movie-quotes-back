<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Mail\UpdateEmail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
	public function update(UserUpdateRequest $request, User $user): JsonResponse
	{
		$query = $request->query('locale');
		if ($request->hasFile('avatar')) {
			$request->validate(['avatar'=>'image|mimes:png,jpg']);
			if ($user->avatar) {
				$fileName = Str::afterLast($user->avatar, '/');
				if ($fileName !== null && Storage::exists("public/avatars/$fileName")) {
					Storage::delete("public/avatars/$fileName");
				}
			}
			$avatarPath = $request->file('avatar')->store('public/avatars');
			$fullPath = asset('storage/' . Str::after($avatarPath, 'public/'));
			$user->avatar = $fullPath;
			$user->save();
			return response()->json(['avatar'=>$user->avatar], 200);
		} else {
			if ($request->username !== null) {
				$user->username = $request->username;
			}
			$email = $request->email;
			if ($email !== null) {
				$token = Str::random(40);
				$user->verification_token = $token;
				$user->save();
				Mail::to($user->email)->locale($query)->send(new UpdateEmail($token, $user->email, $email));
				return response()->json(['email'=>$user->email, 'new_email'=>$email, 'message'=>'email sent successfully'], 200);
			}
			if ($request->password !== null) {
				$user->password = $request->password;
			}
			$user->save();
			return response()->json(['user'=>$user, 'message'=>'success'], 200);
		}
	}
}

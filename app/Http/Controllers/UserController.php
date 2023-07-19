<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Mail\UpdateEmail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UserController extends Controller
{
	public function update(UserUpdateRequest $request, User $user): JsonResponse
	{
		$query = $request->query('locale');
		if ($request->hasFile('avatar')) {
			$request->validate(['avatar'=>'image|mimes:png,jpg']);
			$avatarPath = public_path('storage/avatars/' . $user->avatar);
			if (File::exists($avatarPath)) {
				File::delete($avatarPath);
			}
			$avatar = $request->file('avatar');
			$avatarPath = $avatar->store('public/avatars');
			$user->avatar = basename($avatarPath);
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

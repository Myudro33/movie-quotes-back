<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class EmailVerificationController extends Controller
{
	public function verifyEmail($token): JsonResponse
	{
		$user = User::where('verification_token', $token)->firstOrFail();
		$user->email_verified_at = now();
		$user->verification_token = null;
		$user->save();
		return response()->json(['stage'=>'verified'], 200);
	}

	public function verifyToken(Request $request, User $user): JsonResponse
	{
		$tokenExists = Password::tokenExists($user, $request->token);
		if ($tokenExists) {
			return response()->json(['stage'=>'reset-email-verified'], 200);
		} else {
			return response()->json(['message'=>'token not found'], 404);
		}
	}

	public function updateEmail(EmailUpdateRequest $request, $token): JsonResponse
	{
		$user = User::where('verification_token', $token)->first();
		$user->email = $request->new_email;
		$user->verification_token = null;
		$user->save();
		return response()->json(['stage'=>'email-updated', 'user'=>$user]);
	}
}

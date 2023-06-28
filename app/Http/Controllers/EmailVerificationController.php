<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

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

	public function updateEmail(EmailUpdateRequest $request, $token): JsonResponse
	{
		$user = User::where('verification_token', $token)->first();
		$user->email = $request->new_email;
		$user->verification_token = null;
		$user->save();
		return response()->json(['stage'=>'email-updated', 'user'=>$user]);
	}
}

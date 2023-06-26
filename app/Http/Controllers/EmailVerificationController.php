<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

	public function passwordReset($token): JsonResponse
	{
		$plainTextToken = $token;
		$passwordResetTokens = DB::table('password_reset_tokens')->get();
		foreach ($passwordResetTokens as $passwordResetToken) {
			if (Hash::check($plainTextToken, $passwordResetToken->token)) {
				$user = DB::table('users')->where('email', $passwordResetToken->email)->first();
				return response()->json(['stage'=>'reset-email-verified', 'token'=>$token, 'email'=>$user->email], 200);
				break;
			}
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

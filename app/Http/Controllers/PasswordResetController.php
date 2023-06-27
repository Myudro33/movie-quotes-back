<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
	public function send_reset_password_mail(Request $request, User $user): JsonResponse
	{
		$token = Password::createToken($user);
		$query = $request->query('locale');
		Mail::to($user->email)->locale($query)->send(new ResetPassword($user, $token));
		return response()->json(['message'=>'email sent successfully'], 200);
	}

	public function update(PasswordUpdateRequest $request): JsonResponse
	{
		$status = Password::reset(
			$request->validated(),
			function (User $user, string $password) {
				$user->forceFill([
					'password' => $password,
				]);
				$user->verification_token = null;
				$user->save();
				event(new PasswordReset($user));
			}
		);
		return $status === Password::PASSWORD_RESET
				? response()->json(['message'=>'password updated'], 200)
				: response()->json(['message'=>'error'], 401);
	}
}

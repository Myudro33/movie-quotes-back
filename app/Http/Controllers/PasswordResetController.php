<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
	public function send_reset_password_mail(Request $request)
	{
		$token = Str::random(40);
		DB::table('password_reset_tokens')->insert([
			'email'      => $request->email,
			'token'      => $token,
			'created_at' => now(),
		]);
		Mail::send('email.email-body-password', ['token' => $token], function ($message) use ($request) {
			$message->to($request->email);
			$message->subject('Password Reset');
		});
		return response()->json(['message'=>'email sent successfully'], 200);
	}

	public function reset_password(Request $request)
	{
		$verifyUser = DB::table('password_reset_tokens')
		->where('email', $request->email)
		->where('token', $request->token)
		->first();
		if ($verifyUser) {
			User::where('email', $request->email)->update(['password' => bcrypt($request->password)]);
			return response()->json(['message'=>'password updated', 'request'=>$verifyUser], 200);
		} else {
			return response()->json(['message'=>'nice try :)'], 401);
		}
	}

	public function password_update(Request $request)
	{
		$user = User::where('email', $request->email)->first();
		$user->password = $request->newPassword;
		$user->save();
		return response()->json(['message'=>'password updated :)', 'user'=>$user, 'password'=>$request->newPassword], 200);
	}
}

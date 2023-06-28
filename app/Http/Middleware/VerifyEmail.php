<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VerifyEmail
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next)
	{
		$password = $request->password;
		$user = User::where('email', $request->username)
			->orWhere('username', $request->username)
			->first();
		if ($user) {
			if (Hash::check($password, $user->password)) {
				if (!$user->email_verified_at) {
					return response()->json(['message'=>'You should verify email first'], 403);
				}
			}
		}
		return $next($request);
	}
}

<?php

namespace App\Models;

use App\Notifications\CustomPasswordResetNotification;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
	use HasApiTokens;

	use HasFactory;

	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'username',
		'email',
		'password',
		'google_id',
		'avatar',
	];

	public function movies(): HasMany
	{
		return $this->hasMany(Movie::class);
	}

	public function quotes(): HasMany
	{
		return $this->hasMany(Quote::class);
	}

	public function comments(): HasMany
	{
		return $this->hasMany(Comment::class);
	}

	public function setPasswordAttribute($value): void
	{
		$this->attributes['password'] = Hash::make($value);
		$this->attributes['verification_token'] = Str::random(40);
	}

	public function sendPasswordResetNotification($token): void
	{
		$url = env('FRONTEND_URL') . '/' . $token . '?user=' . $this->getEmailForPasswordReset($token) . '&email=reset-password';

		$notification = new CustomPasswordResetNotification($url);
		$this->notify($notification);
	}

	public function getRouteKeyName()
	{
		return 'email';
	}

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
		'password'          => 'hashed',
	];
}

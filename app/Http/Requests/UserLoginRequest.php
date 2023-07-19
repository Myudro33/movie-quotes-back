<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'username' => 'string|required',
			'password' => 'string|required',
		];
	}
}

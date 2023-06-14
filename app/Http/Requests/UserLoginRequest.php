<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'username' => 'required',
			'password' => 'required',
		];
	}

	public function messages()
	{
		return ['required' => ['en'=>"'field is required.'", 'ka'=>'სავალდებულოა.']];
	}
}

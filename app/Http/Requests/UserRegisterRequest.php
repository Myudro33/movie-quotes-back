<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'username'        => 'required',
			'email'           => 'required|email|unique:users,email',
			'password'        => 'required',
		];
	}

	public function messages()
	{
		return [
			'required'        => ['en'=>'field is required.', 'ka'=>'სავალდებულოა.'],
			'email'           => ['en'=>'field must be a valid email address.', 'ka'=>'ველი უნდა იყოს იმეილის ფორმატის'],
			'unique'          => ['en'=>'has already been taken.', 'ka'=>'უკვე გამოყენებულია'],
		];
	}
}

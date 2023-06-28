<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRegisterRequest extends FormRequest
{
	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response()->json(['message'=>'failure', 'errors' => $validator->errors()], 422));
	}

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

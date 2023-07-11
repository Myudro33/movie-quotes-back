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
			'username'        => 'required|unique:users,username',
			'email'           => 'required|email|unique:users,email',
			'password'        => 'required|confirmed',
		];
	}

	public function messages()
	{
		return [
			'username.unique' => [
				'ka' => __('validation.unique', ['attribute' => 'სახელი'], 'ka'),
				'en' => __('validation.unique', ['attribute' => 'username'], 'en'),
			],
			'email.unique' => [
				'ka' => __('validation.unique', ['attribute' => 'იმეილი'], 'ka'),
				'en' => __('validation.unique', ['attribute' => 'email'], 'en'),
			],
		];
	}
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserLoginRequest extends FormRequest
{
	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response()->json(['message'=>'failure', 'errors' => $validator->errors()], 422));
	}

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

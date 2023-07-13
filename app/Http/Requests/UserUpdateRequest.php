<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserUpdateRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response()->json(['message'=>'error', 'errors' => $validator->errors()], 422));
	}

	public function rules(): array
	{
		return [
			'username'=> 'nullable|min:3|max:15|unique:users,username,lowercase',
			'email'   => 'nullable|email|unique:users,email',
			'password'=> 'nullable|min:8|max:15|lowercase|confirmed',
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

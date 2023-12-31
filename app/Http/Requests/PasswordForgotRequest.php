<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PasswordForgotRequest extends FormRequest
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
			'email'=> 'required|email|exists:users,email',
		];
	}

	public function messages()
	{
		return [
			'email.exists' => [
				'ka' => __('validation.exists', ['attribute' => 'იმეილი'], 'ka'),
				'en' => __('validation.exists', ['attribute' => 'email'], 'en'),
			],
		];
	}
}

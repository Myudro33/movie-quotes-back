<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PasswordUpdateRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response()->json(['message'=>'failure', 'errors' => $validator->errors()], 422));
	}

	public function rules(): array
	{
		return [
			'email'   => 'required|email|exists:users,email',
			'password'=> 'required|min:8|max:15',
			'token'   => 'required',
		];
	}
}

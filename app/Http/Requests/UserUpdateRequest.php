<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserUpdateRequest extends FormRequest
{
	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response()->json(['message'=>'validation failed', 'errors' => $validator->errors()], 422));
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'username'        => 'required|min:3|max:15|lowercase',
			'email'           => 'required|email',
		];
	}
}

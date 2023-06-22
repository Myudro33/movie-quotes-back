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
		$rules = [
			'username'=> 'min:3|max:15|lowercase',
		];
		if (!empty($this->email)) {
			$rules['email'] = 'email';
		}
		if (!empty($this->password)) {
			$rules['password'] = 'min:8|max:15|lowercase';
		}
		if (!empty($this->avatar)) {
			$rules['avatar'] = 'image|mimes:jpg,png';
		}
		return $rules;
	}
}

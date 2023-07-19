<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class MovieStoreRequest extends FormRequest
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
			'user_id'    => 'required|numeric|exists:users,id',
			'name'       => 'required|json',
			'year'       => 'required|numeric',
			'genre'      => 'required|json',
			'description'=> 'required|json',
			'director'   => 'required|json',
		];
	}
}

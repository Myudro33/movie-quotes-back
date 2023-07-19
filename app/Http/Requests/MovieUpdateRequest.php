<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class MovieUpdateRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response()->json(['message'=>'error', 'errors' => $validator->errors()], 422));
	}

	public function rules()
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

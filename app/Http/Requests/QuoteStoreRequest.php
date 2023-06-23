<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class QuoteStoreRequest extends FormRequest
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
			'movie_id'   => 'required|numeric',
			'user_id'    => 'required|numeric',
			'title'      => 'required|json',
			'image'      => 'image|mimes:jpg,png',
		];
	}
}

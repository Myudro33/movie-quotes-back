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
		$rules = [
			'user_id'    => 'required|numeric',
			'name'       => 'required|json',
			'year'       => 'required|numeric',
			'genre'      => 'required|json',
			'description'=> 'required|json',
			'director'   => 'required|json',
		];
		if (!empty($this->avatar)) {
			$rules['image'] = 'image|mimes:jpg,png';
		}
		return $rules;
	}
}

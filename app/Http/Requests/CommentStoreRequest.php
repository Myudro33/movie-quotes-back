<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentStoreRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'user_id' => 'required|numeric|exists:users,id',
			'quote_id'=> 'required|numeric|exists:quotes,id',
			'title'   => 'required|string',
		];
	}
}

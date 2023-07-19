<?php

namespace App\Http\Requests;

use App\Models\Like;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LikeCreateRequest extends FormRequest
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
			'quote_id'=> 'numeric|exists:quotes,id',
			'user_id' => 'numeric|exists:users,id',
		];
	}

	public function withValidator($validator)
	{
		$validator->after(function ($validator) {
			$quoteId = $this->input('quote_id');
			$userId = $this->input('user_id');

			if ($this->userAlreadyLiked($quoteId, $userId)) {
				$validator->errors()->add('user_id', 'The given user has already liked the specified quote.');
			}
		});
	}

	private function userAlreadyLiked($quoteId, $userId)
	{
		return Like::where('quote_id', $quoteId)
			->where('user_id', $userId)
			->exists();
	}
}

<?php

return [
	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	'array'             => 'The :attribute field must be an array.',
	'boolean'           => 'The :attribute field must be true or false.',
	'confirmed'         => 'The :attribute field confirmation does not match.',
	'current_password'  => 'The password is incorrect.',
	'email'             => 'The :attribute field must be a valid email address.',
	'ends_with'         => 'The :attribute field must end with one of the following: :values.',
	'enum'              => 'The selected :attribute is invalid.',
	'exists'            => 'The selected :attribute is invalid.',
	'file'              => 'The :attribute field must be a file.',
	'filled'            => 'The :attribute field must have a value.',
	'image'             => 'The :attribute field must be an image.',
	'lowercase'         => 'The :attribute field must be lowercase.',

	'max_digits' => 'The :attribute field must not have more than :max digits.',
	'mimes'      => 'The :attribute field must be a file of type: :values.',
	'mimetypes'  => 'The :attribute field must be a file of type: :values.',
	'min'        => [
		'array'   => 'The :attribute field must have at least :min items.',
		'file'    => 'The :attribute field must be at least :min kilobytes.',
		'numeric' => 'The :attribute field must be at least :min.',
		'string'  => 'The :attribute field must be at least :min characters.',
	],
	'min_digits'           => 'The :attribute field must have at least :min digits.',
	'required'             => ':attribute სავალდებულოა.',
	'same'                 => 'The :attribute field must match :other.',
	'string'               => 'The :attribute field must be a string.',
	'unique'               => 'მითითებული :attribute უკვე გამოყენებულია.',
	'uppercase'            => 'The :attribute field must be uppercase.',

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => [
		'attribute-name' => [
			'rule-name' => 'custom-message',
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap our attribute placeholder
	| with something more reader friendly such as "E-Mail Address" instead
	| of "email". This simply helps us make our message more expressive.
	|
	*/

	'attributes' => [
		'username'        => 'მომხმარებლის სახელი',
		'email'           => 'იმეილი',
		'password'        => 'პაროლი',
	],
];

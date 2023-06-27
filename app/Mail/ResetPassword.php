<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
	use Queueable;

	use SerializesModels;

	public $user;

	public $token;

	/**
	 * Create a new message instance.
	 */
	public function __construct($user, $token)
	{
		$this->user = $user;
		$this->token = $token;
	}

	public function build()
	{
		return $this->view('emails.reset_password')->with([
			'token' => $this->token,
		])->subject('Password Update');
	}
}

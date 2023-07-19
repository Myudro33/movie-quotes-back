<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
	use Queueable;

	use SerializesModels;

	/**
	 * Create a new message instance.
	 */
	public function __construct(public $user, public $token)
	{
	}

	public function build()
	{
		return $this->view('emails.reset_password')->with([
			'token' => $this->token,
		])->subject('Password Update');
	}
}

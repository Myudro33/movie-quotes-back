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

	/**
	 * Create a new message instance.
	 */
	public function __construct($user)
	{
		$this->user = $user;
	}

	public function build()
	{
		return $this->view('email.email-body-password');
	}
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdateEmail extends Mailable
{
	use Queueable;

	use SerializesModels;

	/**
	 * Create a new message instance.
	 */
	public function __construct(public $token, public $user, public $email)
	{
	}

	public function build()
	{
		return $this->view('emails.email-update')->with([
			'token'    => $this->token,
			'email'    => $this->user,
			'new_email'=> $this->email,
		])->subject('Email Update');
	}
}

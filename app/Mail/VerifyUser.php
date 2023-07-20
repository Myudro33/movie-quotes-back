<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyUser extends Mailable
{
	use Queueable;

	use SerializesModels;

	/**
	 * Create a new message instance.
	 */
	public function __construct(public $user)
	{
	}

	public function build()
	{
		return $this->view('emails.email-body')->subject('Verify User');
	}
}

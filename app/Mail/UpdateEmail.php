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
	public function build()
	{
		return $this->view('email.email-update');
	}
}

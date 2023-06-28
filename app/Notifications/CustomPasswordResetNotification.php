<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomPasswordResetNotification extends Notification
{
	protected $resetUrl;

	public function __construct($resetUrl)
	{
		$this->resetUrl = $resetUrl;
	}

	public function via($notifiable)
	{
		return ['mail'];
	}

	public function toMail($notifiable)
	{
		return (new MailMessage)
		->subject('Reset Password')
		->view(
			'emails.reset_password',
			['url'  => $this->resetUrl,
				'name' => $notifiable->name]
		);
	}
}

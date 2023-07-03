<?php

namespace App\Broadcasting;

class Notification
{
	/**
	 * Create a new channel instance.
	 */
	public function __construct()
	{
	}

	public function join()
	{
		return 'like added';
	}
}

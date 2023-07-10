<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\User;

class MoviePolicy
{
	/**
	 * Determine whether the user can view the model.
	 */
	public function view(User $user, Movie $movie): bool
	{
		return $user->id === $movie->user_id;
	}

	public function delete(User $user, Movie $movie): bool
	{
		return $user->id === $movie->user_id;
	}
}

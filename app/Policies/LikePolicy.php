<?php

namespace App\Policies;

use App\Models\Like;
use App\Models\User;

class LikePolicy
{
	/**
	 * Create a new policy instance.
	 */
	public function delete(User $user, Like $like): bool
	{
		return $user->id === $like->user_id;
	}
}

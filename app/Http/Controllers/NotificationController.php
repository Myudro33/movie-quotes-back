<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Models\User;

class NotificationController extends Controller
{
	public function index(User $user)
	{
		$notifications = Notification::orderByDesc('id')->where('post_author', $user->id)->get();
		return response()->json(['notifications'=>NotificationResource::collection($notifications)]);
	}
}

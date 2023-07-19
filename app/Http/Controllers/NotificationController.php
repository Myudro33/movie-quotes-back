<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
	public function index(): JsonResponse
	{
		$notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->get();
		return response()->json(['notifications'=>NotificationResource::collection($notifications)]);
	}

	public function update(Request $request): JsonResponse
	{
		if ($request->has('id')) {
			Notification::where('id', $request->id)->update(['seen'=>true]);
		} else {
			Notification::where('post_author', $request->post_author)->where('seen', false)->update(['seen'=>true]);
		}
		return response()->json(['message' => 'updated successfully'], 200);
	}
}

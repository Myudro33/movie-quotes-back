<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Http\Requests\LikeCreateRequest;
use App\Http\Requests\LikeDestroyRequest;
use App\Http\Resources\LikeResource;
use App\Http\Resources\NotificationResource;
use App\Models\Like;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
	public function create(LikeCreateRequest $request): JsonResponse
	{
		$like = Like::create([
			'quote_id'=> $request->quote_id,
			'user_id' => $request->user_id,
		]);
		if ($request->author !== auth('sanctum')->user()->id) {
			$notification = Notification::create([
				'type'         => 'like',
				'seen'         => false,
				'user_id'      => auth('sanctum')->user()->id,
				'post_author'  => $request->author,
			]);
			event(new NotificationEvent(new NotificationResource($notification)));
		}
		return response()->json(['message'=>'success', 'like'=>new LikeResource($like)], 201);
	}

	public function destroy(LikeDestroyRequest $request, Like $like): JsonResponse
	{
		$like->delete();
		return response()->json(['message'=>'like deleted'], 204);
	}
}

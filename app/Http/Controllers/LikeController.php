<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Events\PublicNotificationEvent;
use App\Http\Requests\LikeCreateRequest;
use App\Http\Resources\LikeResource;
use App\Http\Resources\NotificationResource;
use App\Models\Like;
use App\Models\Notification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
	public function create(LikeCreateRequest $request): JsonResponse
	{
		$like = Like::create([
			'quote_id'=> $request->quote_id,
			'user_id' => $request->user_id,
		]);
		if ($request->author !== auth()->user()->id) {
			$notification = Notification::create([
				'type'         => 'like',
				'seen'         => false,
				'user_id'      => auth()->user()->id,
				'post_author'  => $request->author,
				'quote_id'     => $request->quote_id,
			]);
			event(new NotificationEvent(new NotificationResource($notification)));
		}
		event(new PublicNotificationEvent(new LikeResource($like), true));
		return response()->json(['message'=>'success', 'like'=>new LikeResource($like)], 201);
	}

	public function destroy(Like $like): JsonResponse
	{
		if (Gate::allows('delete', $like)) {
			$like->delete();
			event(new PublicNotificationEvent(new LikeResource($like), false));
			return response()->json(['message'=>'like deleted'], 204);
		}
	}
}

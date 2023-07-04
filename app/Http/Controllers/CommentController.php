<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\NotificationResource;
use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
	public function create(CommentStoreRequest $request): JsonResponse
	{
		$comment = Comment::create($request->validated());
		$notification = Notification::create([
			'type'         => 'comment',
			'seen'         => false,
			'user_id'      => auth('sanctum')->user()->id,
			'post_author'  => $request->author,
		]);
		event(new NotificationEvent(new NotificationResource($notification)));
		return response()->json(['message'=>'success', 'comment'=>new CommentResource($comment)], 201);
	}
}

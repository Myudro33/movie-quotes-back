<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
	public function create(CommentStoreRequest $request): JsonResponse
	{
		$comment = Comment::create($request->validated());
		return response()->json(['message'=>'success', 'comment'=>new CommentResource($comment)], 201);
	}
}

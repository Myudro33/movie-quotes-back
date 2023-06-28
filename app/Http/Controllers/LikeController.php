<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeCreateRequest;
use App\Http\Requests\LikeDestroyRequest;
use App\Http\Resources\LikeResource;
use App\Models\Like;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
	public function create(LikeCreateRequest $request): JsonResponse
	{
		$like = Like::create([
			'quote_id'=> $request->quote_id,
			'user_id' => $request->user_id,
		]);
		return response()->json(['message'=>'success', 'like'=>new LikeResource($like)], 201);
	}

	public function destroy(LikeDestroyRequest $request, Like $like): JsonResponse
	{
		$like->delete();
		return response()->json(['message'=>'like deleted'], 202);
	}
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeCreateRequest;
use App\Http\Requests\LikeDestroyRequest;
use App\Http\Resources\LikeResource;
use App\Models\Like;

class LikeController extends Controller
{
	public function create(LikeCreateRequest $request)
	{
		$like = Like::create($request->validated());
		return response()->json(['message'=>'success', 'like'=>new LikeResource($like)], 201);
	}

	public function destroy(LikeDestroyRequest $request)
	{
		$like = Like::where('user_id', $request->user_id)->where('quote_id', $request->quote_id)->first();
		$like->delete();
		return response()->json(['message'=>'like deleted', 'like'=>new LikeResource($like)], 202);
	}
}

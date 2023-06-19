<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeCreateRequest;
use App\Http\Resources\LikeResource;
use App\Models\Like;

class LikeController extends Controller
{
	public function create(LikeCreateRequest $request)
	{
		$new_like = Like::where('user_id', $request->user_id)->where('quote_id', $request->quote_id)->first();
		if (!$new_like) {
			$like = Like::create([
				'quote_id'=> $request->quote_id,
				'user_id' => $request->user_id,
			]);
			return response()->json(['message'=>'success', 'like'=>new LikeResource($like)], 201);
		} else {
			$new_like->delete();
			return response()->json(['message'=>'like deleted', 'like'=>new LikeResource($new_like)], 202);
		}
	}
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeCreateRequest;
use App\Http\Resources\LikeResource;
use App\Models\Like;

class LikeController extends Controller
{
	public function create(LikeCreateRequest $request)
	{
		$like = Like::create([
			'quote_id'=> $request->quote_id,
			'user_id' => $request->user_id,
		]);
		return response()->json(['message'=>'success', 'like'=>new LikeResource($like)], 201);
	}

	public function delete(Like $like)
	{
		$like->delete();
		return response()->json(['message'=>'like deleted'], 202);
	}
}

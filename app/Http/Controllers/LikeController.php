<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikeResource;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
	public function create(Request $request)
	{
		$like = Like::create([
			'quote_id'=> $request->quote_id,
			'user_id' => $request->user_id,
		]);
		return response()->json(['message'=>'success', 'like'=>new LikeResource($like)], 201);
	}

	public function destroy(Request $request)
	{
		$like = Like::where('user_id', $request->user_id)->where('quote_id', $request->quote_id)->first();
		$like->delete();
		return response()->json(['message'=>'like deleted', 'like'=>new LikeResource($like)], 202);
	}
}

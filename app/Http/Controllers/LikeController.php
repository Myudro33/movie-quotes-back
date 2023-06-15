<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
	public function like(Request $request)
	{
		$new_like = Like::where('user_id', $request->user_id)->where('quote_id', $request->quote_id)->first();
		if (!$new_like) {
			Like::create([
				'quote_id'=> $request->quote_id,
				'user_id' => $request->user_id,
			]);
		} else {
			$new_like->delete();
		}
		return response()->json(['message'=>'success'], 201);
	}
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
	public function create(Request $request)
	{
		$comment = Comment::create([
			'user_id' => $request->user_id,
			'quote_id'=> $request->quote_id,
			'title'   => $request->title,
		]);
		return response()->json(['message'=>'success', 'comment'=>new CommentResource($comment)], 201);
	}
}

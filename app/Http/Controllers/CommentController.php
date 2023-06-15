<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
	public function add_comment(Request $request)
	{
		Comment::create([
			'user_id' => $request->user_id,
			'quote_id'=> $request->quote_id,
			'title'   => $request->title,
		]);
		return response()->json(['message'=>'success'], 201);
	}
}

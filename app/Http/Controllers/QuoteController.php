<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuotePostResource;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
	public function index()
	{
		$quotes = Quote::with('comments', 'likes')->get();
		return response()->json(['quotes'=>QuoteResource::collection($quotes)], 200);
	}

	public function store(Request $request)
	{
		$image = $request->file('image');
		$filename = $image->getClientOriginalName();
		$image->storeAs('images', $filename, 'public');
		$quote = Quote::create([
			'movie_id'=> $request->movie_id,
			'user_id' => $request->user_id,
			'title'   => $request->title,
			'image'   => asset('storage/images/' . $filename),
		]);
		return response()->json(['message'=>'quote created', 'quote'=>new QuotePostResource($quote)], 201);
	}
}

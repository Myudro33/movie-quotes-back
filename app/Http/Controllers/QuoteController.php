<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteStoreRequest;
use App\Http\Resources\QuotePostResource;
use App\Http\Resources\QuoteResourceCollection;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
	public function index(Request $request)
	{
		$perPage = $request->input('perPage', 10); // Number of posts per page
		$page = $request->input('page', 1); // Current page number
		$quotes = Quote::with('comments')->paginate($perPage, ['*'], 'page', $page);
		return response()->json(['quotes'=>new QuoteResourceCollection($quotes)], 200);
	}

	public function store(QuoteStoreRequest $request)
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

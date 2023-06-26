<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteStoreRequest;
use App\Http\Resources\QuotePostResource;
use App\Http\Resources\QuoteResource;
use App\Http\Resources\QuoteResourceCollection;
use App\Models\Movie;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
	public function index(Request $request)
	{
		$perPage = $request->input('perPage', 10);
		$page = $request->input('page', 1);
		$quotes = Quote::with('comments')
		->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);
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

	public function filter(Request $request)
	{
		$query = $request->query('query');
		if (strpos($query, '#') === 0) {
			$quote = substr($query, 1);
			$post = Quote::query()
			->where('title->en', 'LIKE', "%$quote%")
			->orWhere('title->ka', 'LIKE', "%$quote%")
			->get();
			return response()->json(['message'=>'success', 'quotes'=>QuoteResource::collection($post)], 200);
		} elseif (strpos($query, '@') === 0) {
			$quote = substr($query, 1);
			$post = Movie::query()
			->where('name->en', 'LIKE', "%$quote%")
			->orWhere('name->ka', 'LIKE', "%$quote%")
			->with('quotes')
			->get();
			$movieNames = $post->pluck('quotes')->unique()->values();
			return response()->json(['message'=>'movie', 'quotes'=>QuoteResource::collection($movieNames[0])], 200);
		} else {
			return response()->json(['message'=>'quotes', 'quotes'=>QuoteResource::collection(Quote::all())]);
		}
	}
}

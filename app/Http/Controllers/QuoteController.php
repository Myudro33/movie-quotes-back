<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteStoreRequest;
use App\Http\Resources\QuotePostResource;
use App\Http\Resources\QuoteResource;
use App\Http\Resources\QuoteResourceCollection;
use App\Models\Movie;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
	public function index(Request $request): JsonResponse
	{
		$query = $request->query('query');
		if (strpos($query, '#') === 0) {
			$quote = substr($query, 1);
			$quotes = Quote::query()
			->where('title->en', 'LIKE', "%$quote%")
			->orWhere('title->ka', 'LIKE', "%$quote%")
			->get();
			return response()->json(['message'=>'success', 'quotes'=>QuoteResource::collection($quotes)], 200);
		} elseif (strpos($query, '@') === 0) {
			$quote = substr($query, 1);
			$post = Movie::query()
			->where('name->en', 'LIKE', "%$quote%")
			->orWhere('name->ka', 'LIKE', "%$quote%")
			->with('quotes')
			->get();
			$quotes = $post->pluck('quotes');
			return response()->json(['message'=>'success', 'quotes'=>QuoteResource::collection($quotes[0])], 200);
		} else {
			$perPage = $request->input('perPage', 10);
			$page = $request->input('page', 1);
			$quotes = Quote::with('comments')
			->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);
			return response()->json(['quotes'=>new QuoteResourceCollection($quotes)], 200);
		}
	}

	public function store(QuoteStoreRequest $request): JsonResponse
	{
		$imagePath = $request->file('image')->store('public/images');

		$quote = Quote::create([
			'image'   => basename($imagePath),
			...$request->validated(),
		]);
		return response()->json(['message'=>'quote created', 'quote'=>new QuotePostResource($quote)], 201);
	}
}

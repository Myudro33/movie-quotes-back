<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuoteStoreRequest;
use App\Http\Requests\QuoteUpdateRequest;
use App\Http\Resources\MovieQuotesResource;
use App\Http\Resources\QuotePostResource;
use App\Http\Resources\QuoteResource;
use App\Http\Resources\QuoteResourceCollection;
use App\Models\Movie;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

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

	public function update(QuoteUpdateRequest $request, Quote $quote): JsonResponse
	{
		if (Gate::allows('update', $quote)) {
			if ($request->hasFile('image')) {
				$request->validate(['image'=>'image|mimes:png,jpg']);
				$imagePath = public_path('storage/images/' . $quote->image);
				if (File::exists($imagePath)) {
					File::delete($imagePath);
				}
				$imagePath = $request->file('image')->store('public/images');
				$quote->update(
					[
						'image'      => basename($imagePath),
						'title'      => $request->validated()['title'],
					]
				);
			} else {
				$quote->update(['title'=>$request->validated()['title']]);
			}
			return response()->json(['message'=>'success', 'quote'=>new MovieQuotesResource($quote)]);
		} else {
			return response()->json(['error'=>'You can"t update this quote.'], 403);
		}
	}
}

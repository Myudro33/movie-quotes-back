<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieStoreRequest;
use App\Http\Requests\MovieUpdateRequest;
use App\Http\Resources\MovieResource;
use App\Http\Resources\MovieResourceCollection;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class MovieController extends Controller
{
	public function index(Request $request): JsonResponse
	{
		$query = $request->query('query');
		if ($query) {
			$movies = Movie::where('user_id', auth()->user()->id)->filterByName($query)->with('quotes')->get();
			return response()->json(['movies'=>MovieResource::collection($movies)]);
		}
		$perPage = $request->input('perPage', 10);
		$page = $request->input('page', 1);
		$movies = Movie::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')
		->paginate($perPage, ['*'], 'page', $page);
		return response()->json(['message'=>'success', 'movies'=>new MovieResourceCollection($movies)]);
	}

	public function show(Movie $movie): JsonResponse
	{
		if (Gate::allows('view', $movie)) {
			return response()->json(['message'=>'success', 'movie'=>new MovieResource($movie)], 200);
		} else {
			return response()->json(['error'=>"You can't see this movie."], 403);
		}
	}

	public function store(MovieStoreRequest $request): JsonResponse
	{
		$request->validate(['image'=>'image|mimes:png,jpg']);
		$imagePath = $request->file('image')->store('public/images');
		$movie = Movie::create([
			'image'=> basename($imagePath), ...$request->validated(),
		]);
		$genreData = json_decode($request->genre, true);
		$genreIds = array_column($genreData, 'id');
		$genres = Genre::whereIn('id', $genreIds)->get();
		$movie->genres()->attach($genres);
		return response()->json(['message'=>'movie created', 'movie'=>new MovieResource($movie)], 201);
	}

	public function update(MovieUpdateRequest $request, Movie $movie): JsonResponse
	{
		if ($request->hasFile('image')) {
			$request->validate(['image'=>'image|mimes:png,jpg']);
			$imagePath = public_path('storage/images/' . $movie->image);
			if (File::exists($imagePath)) {
				File::delete($imagePath);
			}
			$imagePath = $request->file('image')->store('public/images');
			$movie->update(
				[
					'image'      => basename($imagePath),
					...$request->validated(),
				]
			);
		} else {
			$movie->update($request->validated());
		}
		$genreData = json_decode($request->genre, true);
		$genreIds = array_column($genreData, 'id');
		$genres = Genre::whereIn('id', $genreIds)->get();
		$movie->genres()->detach();
		$movie->genres()->attach($genres);
		return response()->json(['message'=>'movie updated', 'movie'=>new MovieResource($movie)], 201);
	}

	public function destroy(Movie $movie): JsonResponse
	{
		$movie->delete();
		return response()->json(['message'=>'movie deleted', 'movie'=>$movie], 202);
	}
}

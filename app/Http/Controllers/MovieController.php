<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieStoreRequest;
use App\Http\Requests\MovieUpdateRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;

class MovieController extends Controller
{
	public function index()
	{
		return MovieResource::collection(Movie::all());
	}

	public function get(Movie $movie)
	{
		return response()->json(['message'=>'success', 'movie'=>new MovieResource($movie)], 200);
	}

	public function store(MovieStoreRequest $request)
	{
		$image = $request->file('image');
		$filename = $image->getClientOriginalName();
		$image->storeAs('images', $filename, 'public');
		$movie = Movie::create([
			'user_id'    => $request->user_id,
			'name'       => $request->name,
			'year'       => $request->year,
			'image'      => asset('storage/images/' . $filename),
			'genre'      => $request->genre,
			'description'=> $request->description,
			'director'   => $request->director,
		]);
		return response()->json(['message'=>'movie created', 'movie'=>$movie], 201);
	}

	public function update(MovieUpdateRequest $request, Movie $movie)
	{
		if ($request->hasFile('image')) {
			$image = $request->file('image');
			$filename = $image->getClientOriginalName();
			$image->storeAs('images', $filename, 'public');
			$movie->update([
				'user_id'    => $request->user_id,
				'name'       => $request->name,
				'year'       => $request->year,
				'image'      => asset('storage/images/' . $filename),
				'genre'      => $request->genre,
				'description'=> $request->description,
				'director'   => $request->director,
			]);
			return response()->json(['message'=>'movie updated', 'movie'=>new MovieResource($movie)], 201);
		} else {
			$movie->update([
				'user_id'    => $request->user_id,
				'name'       => $request->name,
				'year'       => $request->year,
				'genre'      => $request->genre,
				'description'=> $request->description,
				'director'   => $request->director,
			]);
			return response()->json(['message'=>'movie updated', 'movie'=>new MovieResource($movie)], 201);
		}
	}

	public function delete(Movie $movie)
	{
		$movie->delete();
		return response()->json(['message'=>'movie deleted', 'movie'=>$movie], 202);
	}
}

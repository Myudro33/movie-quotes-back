<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieStoreRequest;
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
}

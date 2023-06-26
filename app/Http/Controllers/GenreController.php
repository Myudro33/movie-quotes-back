<?php

namespace App\Http\Controllers;

use App\Models\Genre;

class GenreController extends Controller
{
	public function index()
	{
		return response()->json(['message'=>'success', 'genres'=>Genre::all(['id', 'name'])]);
	}
}

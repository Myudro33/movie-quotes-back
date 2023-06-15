<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuoteResource;
use App\Models\Quote;

class QuoteController extends Controller
{
	public function get_quotes()
	{
		$quotes = Quote::with('comments', 'likes')->get();

		return QuoteResource::collection($quotes);
	}
}

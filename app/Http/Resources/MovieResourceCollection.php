<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MovieResourceCollection extends ResourceCollection
{
	/**
	 * Transform the resource collection into an array.
	 *
	 * @return array<int|string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'data' => MovieResource::collection($this->collection),
			'meta' => [
				'pagination' => [
					'total'        => $this->total(),
					'per_page'     => $this->perPage(),
					'current_page' => $this->currentPage(),
					'last_page'    => $this->lastPage(),
				],
			],
		];
	}
}

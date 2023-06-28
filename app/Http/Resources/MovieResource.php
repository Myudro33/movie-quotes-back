<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'         => $this->id,
			'name'       => json_decode($this->name),
			'year'       => $this->year,
			'image'      => $this->image,
			'genre'      => GenresResource::collection(json_decode($this->genres)),
			'description'=> json_decode($this->description),
			'director'   => json_decode($this->director),
			'quotes'     => MovieQuotesResource::collection($this->quotes),
			'author'     => new UserResource($this->author),
		];
	}
}

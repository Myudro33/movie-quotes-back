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
			'genre'      => json_decode($this->genre),
			'description'=> json_decode($this->description),
			'director'   => $this->director,
		];
	}
}

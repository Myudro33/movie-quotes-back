<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieQuotesResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'      => $this->id,
			'movie_id'=> $this->movie_id,
			'user'    => new UserResource($this->author),
			'title'   => json_decode($this->title),
			'image'   => $this->image,
			'likes'   => LikeResource::collection($this->likes),
			'comments'=> CommentResource::collection($this->comments),
		];
	}
}

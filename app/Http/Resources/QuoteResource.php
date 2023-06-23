<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'       => $this->id,
			'title'    => json_decode($this->title),
			'image'    => $this->image,
			'user'     => new UserResource($this->author),
			'movie'    => new MovieResource($this->movie),
			'comments' => CommentResource::collection($this->whenLoaded('comments')),
			'likes'    => LikeResource::collection($this->likes),
		];
	}
}

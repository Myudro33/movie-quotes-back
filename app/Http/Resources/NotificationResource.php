<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'           => $this->id,
			'type'         => $this->type,
			'seen'         => $this->seen,
			'user'         => new UserResource($this->author),
			'post_author'  => $this->post_author,
			'date'         => $this->created_at->diffForHumans(),
		];
	}
}

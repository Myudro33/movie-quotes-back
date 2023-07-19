<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
	use HasFactory;

	protected $hidden = ['created_at', 'updated_at'];

	protected $fillable = ['name', 'movie_id', 'genre_id'];

	protected $casts = [
		'name' => 'array',
	];

	public function movies(): BelongsToMany
	{
		return $this->belongsToMany(Movie::class);
	}
}

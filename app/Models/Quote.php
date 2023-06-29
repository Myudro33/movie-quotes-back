<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quote extends Model
{
	use HasFactory;

	protected $fillable = ['image', 'title', 'movie_id', 'user_id'];

	public function scopeFilterByTitle($query, $quote)
	{
		return $query->where('title->en', 'LIKE', "%$quote%")
			->orWhere('title->ka', 'LIKE', "%$quote%");
	}

	public function scopeFilterByName($query, $quote)
	{
		return $query->where('name->en', 'LIKE', "%$quote%")
			->orWhere('name->ka', 'LIKE', "%$quote%");
	}

	public function movie(): BelongsTo
	{
		return $this->belongsTo(Movie::class, 'movie_id');
	}

	public function author(): BelongsTo
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function comments(): HasMany
	{
		return $this->hasMany(Comment::class);
	}

	public function likes(): HasMany
	{
		return $this->hasMany(Like::class);
	}
}

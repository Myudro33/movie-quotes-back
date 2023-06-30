<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
	use HasFactory;

	protected $fillable = ['name', 'user_id', 'year', 'image', 'director', 'description'];

	public function scopeFilterByName($query, $quote)
	{
		return $query->where('name->en', 'LIKE', "%$quote%")
			->orWhere('name->ka', 'LIKE', "%$quote%");
	}

	public function author(): BelongsTo
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function quotes(): HasMany
	{
		return $this->hasMany(Quote::class);
	}

	public function genres(): BelongsToMany
	{
		return $this->belongsToMany(Genre::class);
	}
}

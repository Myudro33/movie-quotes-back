<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Movie extends Model
{
	use HasFactory;

	protected $fillable = ['name', 'user_id', 'year', 'image', 'genre', 'director', 'description'];

	public function author()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function quotes()
	{
		return $this->hasMany(Quote::class);
	}

	protected function genre(): Attribute
	{
		return Attribute::make(
			get: fn ($value) => json_decode($value, true),
			set: fn ($value) => json_encode($value),
		);
	}
}

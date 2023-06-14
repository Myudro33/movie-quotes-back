<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
	use HasFactory;

	protected $fillable = ['name', 'user_id'];

	public function author()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function quotes()
	{
		return $this->hasMany(Quote::class);
	}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
	use HasFactory;

	protected $fillable = [
		'quote_id',
		'user_id',
	];

	public function quote(): BelongsTo
	{
		return $this->belongsTo(Quote::class, 'quote_id');
	}

	public function author(): BelongsTo
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}

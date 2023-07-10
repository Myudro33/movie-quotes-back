<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
	use HasFactory;

	protected $fillable = ['type', 'user_id', 'seen', 'post_author'];

	public function post_author(): BelongsTo
	{
		return $this->belongsTo(User::class, 'post_author');
	}
}

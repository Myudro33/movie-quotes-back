<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenreMovieTable extends Migration
{
	public function up()
	{
		Schema::create('genre_movie', function (Blueprint $table) {
			$table->foreignId('genre_id')->constrained('genres')
			->onDelete('cascade');
			$table->foreignId('movie_id')->constrained('movies')
			->onDelete('cascade');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('genre_movie');
	}
}

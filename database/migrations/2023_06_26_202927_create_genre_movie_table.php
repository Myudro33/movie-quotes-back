<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenreMovieTable extends Migration
{
	public function up()
	{
		Schema::create('genre_movie', function (Blueprint $table) {
			$table->smallInteger('genre_id')->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
			$table->smallInteger('movie_id')->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('genre_movie');
	}
}

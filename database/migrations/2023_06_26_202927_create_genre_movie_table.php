<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenreMovieTable extends Migration
{
	public function up()
	{
		Schema::create('genre_movie', function (Blueprint $table) {
			$table->unsignedBigInteger('genre_id');
			$table->unsignedBigInteger('movie_id');
			$table->timestamps();
			$table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
			$table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::dropIfExists('genre_movie');
	}
}

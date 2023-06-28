<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('movies', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained('users')
			->onDelete('cascade');
			$table->json('name');
			$table->smallInteger('year');
			$table->string('image');
			$table->json('description');
			$table->json('director');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('movies');
	}
};

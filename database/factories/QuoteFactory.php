<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'title'      => json_encode([
				'en'=> fake()->word(),
				'ka'=> fake()->word(),
			]),
			'image'              => fake()->imageUrl(),
			'movie_id'           => fake()->numberBetween(1, 2),
			'user_id'            => fake()->numberBetween(1, 2),
		];
	}
}

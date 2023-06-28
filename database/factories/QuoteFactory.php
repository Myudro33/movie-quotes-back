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
		$fakerKa = \Faker\Factory::create('ka_GE');
		return [
			'title'      => json_encode([
				'en'=> fake()->word(),
				'ka'=> $fakerKa->realText(10),
			]),
			'image'              => fake()->imageUrl(),
			'movie_id'           => fake()->numberBetween(1, 2),
			'user_id'            => fake()->numberBetween(1, 2),
		];
	}
}

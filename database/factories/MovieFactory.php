<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
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
			'user_id'    => fake()->numberBetween(1, 5),
			'name'       => json_encode([
				'en'=> fake()->word(),
				'ka'=> $fakerKa->realText(10),
			]),
			'year'       => fake()->numberBetween(1970, 2023),
			'image'      => fake()->imageUrl(),
			'genre'      => json_encode([
				'en'=> fake()->word(),
				'ka'=> $fakerKa->realText(10),
			]),
			'description'=> json_encode([
				'en'=> fake()->sentence(),
				'ka'=> $fakerKa->realText(10),
			]),
			'director'   => fake()->userName(),
		];
	}
}

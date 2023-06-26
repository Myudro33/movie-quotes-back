<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$genres = $genres = [
			[
				'en' => 'Thriller',
				'ka' => 'თრილერი',
			],
			[
				'en' => 'Drama',
				'ka' => 'დრამა',
			],
			[
				'en' => 'Action',
				'ka' => 'ექშენი',
			],
			[
				'en' => 'Fantasy',
				'ka' => 'ფანტაზია',
			],
			[
				'en' => 'Fiction',
				'ka' => 'ფიქცია',
			],
			[
				'en' => 'Comedy',
				'ka' => 'კომედია',
			],
			[
				'en' => 'Horror',
				'ka' => 'საშიში',
			],
			[
				'en' => 'Animated',
				'ka' => 'ანიმაცია',
			],
			[
				'en' => 'Crime',
				'ka' => 'კრიმინალური',
			],
			[
				'en' => 'Documentary',
				'ka' => 'დოკუმენტური',
			],
		];

		foreach ($genres as $genre) {
			Genre::create(['name' => $genre]);
		}
	}
}

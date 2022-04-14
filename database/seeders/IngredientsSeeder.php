<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class IngredientsSeeder extends Seeder {
 
	public function run()
	{
		DB::table('ingredients')->delete();
		DB::table('ingredients')->insert(
			[
				'ingredient_name' => 'cheese',
				'remaining_quantity' => 5000
			]
		);

		DB::table('ingredients')->insert(
			[
				'ingredient_name' => 'beef',
				'remaining_quantity' => 20000
			]
		);

		DB::table('ingredients')->insert(
			[
				'ingredient_name' => 'onion',
				'remaining_quantity' => 1000
			]
		);
	}
}
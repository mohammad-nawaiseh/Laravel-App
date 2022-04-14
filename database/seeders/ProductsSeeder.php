<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ProductsSeeder extends Seeder {
 
	public function run()
	{
        DB::table('products')->delete();
		DB::table('products')->insert(
			[
				'product_name' => 'kamikaze',
				'product_description' => 'Lettuce,Cheese,Tomato,Caramelized Onion,F.F sauce,pickles,Sweet Chili Sauce',
                'product_price' => '25$',
				'product_image' => 'http://storage.burgerfirefly.com/uploads//Kamikaze.jpg',
                'cheese_weight' => 30,
				'beef_weight' => 150,
                'onion_weight' => 20
			]
		);

        DB::table('products')->insert(
			[
				'product_name' => 'Backfire burger',
				'product_description' => 'Lettuce,Cheese,Tomato,Jalapeño,Fresh red onion ,Hot sauce  ,Chili lava sauce',
                'product_price' => '35$',
				'product_image' => 'http://storage.burgerfirefly.com/uploads//Backfire.jpg',
                'cheese_weight' => 25,
				'beef_weight' => 100,
                'onion_weight' => 20
			]
		);

		DB::table('products')->insert(
			[
				'product_name' => 'Egg bacon',
				'product_description' => 'Lettuce,Cheese,Tomato,Caramelized Onion,pickles,Egg,Beef Bacon,mayonnaise',
                'product_price' => '15$',
				'product_image' => 'http://storage.burgerfirefly.com/uploads//Egg%20bacon.jpg',
                'cheese_weight' => 20,
				'beef_weight' => 100,
                'onion_weight' => 20
			]
		);

        DB::table('products')->insert(
			[
				'product_name' => 'Bucharest Grilled chicken ',
				'product_description' => 'Lettuce,Cheese,Tomato,pickles,Turkey Slice,Bucharest sauce',
                'product_price' => '40$',
				'product_image' => 'http://storage.burgerfirefly.com/uploads//Bucharest%20grilled.jpg',
                'cheese_weight' => 35,
				'beef_weight' => 200,
                'onion_weight' => 20
			]
		);
	}
}
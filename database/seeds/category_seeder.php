<?php

use Illuminate\Database\Seeder;

class category_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i = 0; $i < 20 ; $i++) { 
    		DB::table('categories')->insert([
         	'parent_id' => 0,
         	'name' => rand(0, 10000)
         ]);
    	}
         
    }
}

<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 20; $i++) {
            DB::table('categories')->insert([
                'parent_id' => rand(0, 3),
                'title' => $faker->name,
            ]);
        }
    }
}

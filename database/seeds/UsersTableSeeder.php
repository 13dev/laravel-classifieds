<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
                [
                'name' => 'Leonardo',
                'last_name' => 'Gomes',
                'username' => 'leonardo',
                'email' => 'leonardo@email.com',
                'password' => bcrypt('123456'),
                'verified' => 1,
                'is_admin' => 1,
            ],
                [
                'name' => 'Pedro',
                'last_name' => 'Gomes',
                'username' => 'pedro',
                'email' => 'pedro@email.com',
                'password' => bcrypt('123456'),
                'verified' => 1,
                'is_admin' => 0,
            ],
                [
                'name' => 'Joao',
                'last_name' => 'Gomes',
                'username' => 'joao',
                'email' => 'joao@email.com',
                'password' => bcrypt('123456'),
                'verified' => 1,
                'is_admin' => 1,
            ],
        ]);

        $faker = Faker\Factory::create();

        for ($index = 0; $index < 30; $index++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'last_name' => $faker->lastName,
                'username' => $faker->userName,
                'email' => $faker->email,
                'password' => bcrypt($faker->password),
                'verified' => 1,
             ]);
        }
    }
}

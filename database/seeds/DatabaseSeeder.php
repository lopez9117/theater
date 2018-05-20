<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'name' => "admin",
            "last_name" => "admin",
            'email' => "admin@correo.com",
            'rol' => 'admin',
            'password' => bcrypt("123123"),
            'remember_token' => str_random(10),
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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
                'id' => 1,
                'username' => "admin",
                'email' => "super_administrator@localhost.com",
                'password' => Hash::make('12345'),
                'id_role' => 1
            ]
        ]);
    }
}

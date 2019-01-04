<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
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
                'name' => 'Arseniys',
                'email' => 'thevalakas1@gmail.com',
                'password' => Hash::make('root'),
                'vpn_username' => str_random(30),
                'vpn_password' => str_random(30),
                'locale' => 'ru',
            ],
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersSeeder::class,
            AccessSeeder::class,
            UserAccessSeeder::class,
            CountriesSeeder::class,
            VpnServersSeeder::class,
        ]);
    }
}

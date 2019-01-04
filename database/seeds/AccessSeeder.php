<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('access')->insert([
            [
                'name' => 'plan1',
                'name_humanity' => 'plan1',
                'duration' => 2592000,
                'duration_humanity' => '1mouth',
                'price' => 5 * 100,
            ],
        ]);
    }
}

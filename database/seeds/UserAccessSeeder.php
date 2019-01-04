<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_access')->insert([
            [
                'user_id' => 1,
                'access_id' => 1,
                'end_at' => time() + 2592000,
            ]
        ]);
    }
}

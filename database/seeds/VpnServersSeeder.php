<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VpnServersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vpn_servers')->insert([
            [
                'country_id' => 1,
                'ip' => '127.0.0.1',
                'port' => '80',
                'vps_username' => 'root',
                'vps_password' => 'root',
                'max_online' => 100,
                'online_counter' => 0,
                'online' => false,
                'show' => true,
                'banned' => false,
                'free' => false,
                'token' => Str::random(30),
            ],
        ]);
    }
}

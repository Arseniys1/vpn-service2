<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'name_humanity' => 'admin'
            ],
            [
                'name' => 'users',
                'name_humanity' => 'users'
            ],
            [
                'name' => 'users.create',
                'name_humanity' => 'users.create'
            ],
            [
                'name' => 'users.edit',
                'name_humanity' => 'users.edit'
            ],
            [
                'name' => 'users.delete',
                'name_humanity' => 'users.delete'
            ],
            [
                'name' => 'payments',
                'name_humanity' => 'payments'
            ],
            [
                'name' => 'payments.detail',
                'name_humanity' => 'payments.detail'
            ],
        ]);
    }
}

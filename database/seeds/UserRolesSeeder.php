<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRoles = [];

        foreach (DB::table('roles')->get() as $role) {
            $userRoles[] = [
                'user_id' => 1,
                'role_id' => $role->id,
            ];
        }

        DB::table('user_roles')->insert($userRoles);
    }
}

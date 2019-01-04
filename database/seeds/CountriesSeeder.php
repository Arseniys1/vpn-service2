<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([
            ['name' => 'Россия', 'iso' => 'RU', 'image' => 'ru.png'],
            ['name' => 'Germany', 'iso' => 'DEU', 'image' => 'deu.png'],
        ]);
    }
}

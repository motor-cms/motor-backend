<?php

namespace Motor\Backend\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class ClientsTableSeeder
 */
class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            'iso_639_1'    => 'de',
            'english_name' => 'German',
            'native_name'  => 'Deutsch',
        ]);

        DB::table('languages')->insert([
            'iso_639_1'    => 'en',
            'english_name' => 'English',
            'native_name'  => 'English',
        ]);
    }
}

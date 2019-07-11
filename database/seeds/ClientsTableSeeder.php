<?php

use Illuminate\Database\Seeder;
use Motor\Backend\Models\User;

/**
 * Class ClientsTableSeeder
 */
class ClientsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            'name'       => 'Default',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}

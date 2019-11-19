<?php

use Illuminate\Database\Seeder;

/**
 * Class ClientsTableSeeder
 */
class PermissionsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('motor:create:permissions');
    }
}

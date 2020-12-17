<?php

namespace Motor\Backend\Database\Seeders;

use Illuminate\Database\Seeder;

class MotorBackendDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            ClientsTableSeeder::class,
            LanguagesTableSeeder::class,
            PermissionsTableSeeder::class,
        ]);
    }
}

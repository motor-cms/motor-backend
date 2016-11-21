<?php

use Illuminate\Database\Seeder;
use Motor\Backend\Models\User;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'       => 'Motor Admin',
            'email'      => 'motor@esmaili.info',
            'password'   => bcrypt('admin'),
            'api_token'  => str_random(60),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('roles')->insert([
            'name'       => 'SuperAdmin'
        ]);

        $user = User::where('email', 'motor@esmaili.info')->first();
        $user->assignRole('SuperAdmin');
    }
}

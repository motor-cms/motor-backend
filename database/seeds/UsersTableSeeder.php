<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Motor\Backend\Models\User;

/**
 * Class UsersTableSeeder
 */
class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name'       => 'SuperAdmin'
        ]);

        DB::table('users')->insert([
            'name'       => 'Motor Admin',
            'email'      => 'motor@esmaili.info',
            'password'   => bcrypt('admin'),
            'api_token'  => Str::random(60),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $user = User::where('email', 'motor@esmaili.info')->first();
        $user->assignRole('SuperAdmin');
    }
}

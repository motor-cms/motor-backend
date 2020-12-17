<?php

namespace Motor\Backend\Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Motor\Backend\Models\Role;
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
        DB::table('users')->insert([
            'name'       => 'Motor Admin',
            'email'      => 'motor@esmaili.info',
            'password'   => bcrypt('admin'),
            'api_token'  => Str::random(60),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $role = Role::where('name', 'SuperAdmin')->first();
        $user = User::where('email', 'motor@esmaili.info')->first();

        $user->assignRole($role);
    }
}

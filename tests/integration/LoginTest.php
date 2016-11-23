<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{

    use DatabaseTransactions;

    protected $user;

    protected $role;

    protected $permission;

    protected $tables = [ 'users', 'clients', 'permissions', 'user_has_permissions', 'user_has_roles', 'roles' ];

    /** @test */
    public function user_exists_in_database()
    {
        $this->createUser();

        $this->seeInDatabase('users', [
            'email' => $this->user->email
        ]);
    }


    /** @test */
    public function user_cannot_log_in_without_password()
    {
        $this->createUser();

        $this->visit('/login')->type($this->user->email,
            'email')->press('Sign in')->see('The password field is required.');
    }


    /** @test */
    public function user_cannot_log_in_with_wrong_password()
    {
        $this->createUser();

        $this->visit('/login')->type($this->user->email, 'email')->type('wrong_password',
            'password')->press('Sign in')->see('These credentials do not match our records.');
    }


    /** @test */
    public function user_can_log_in_and_see_dashboard_as_superadmin()
    {
        $this->createUser();
        $this->createRole();
        $this->user->assignRole($this->role);

        $this->visit('/login')->type($this->user->email, 'email')->type('secret',
            'password')->press('Sign in')->see('Dashboard');
    }


    /** @test */
    public function user_can_log_in_and_can_see_dashboard()
    {
        $this->createUser();
        $this->createPermission();
        $this->user->givePermissionTo('dashboard.read');

        $this->visit('/login')->type($this->user->email, 'email')->type('secret',
            'password')->press('Sign in')->see('Dashboard');

    }


    /**
     * @test
     */
    public function user_can_log_in_and_cannot_see_dashboard()
    {
        $this->createUser();

        $this->createPermission();

        try {
            $this->visit('/login')->type($this->user->email, 'email')->type('secret', 'password')->press('Sign in');
        } catch (\Exception $e) {
            $this->assertContains("Received status code [403]", $e->getMessage());
        }
    }


    protected function createUser()
    {
        $this->user = factory(Motor\Backend\Models\User::class)->create();
    }


    protected function createRole()
    {
        $this->role = factory(Motor\Backend\Models\Role::class)->create([ 'name' => 'SuperAdmin' ]);
    }


    protected function createPermission()
    {
        $this->permission = factory(Motor\Backend\Models\Permission::class)->create([ 'name' => 'dashboard.read' ]);
        factory(Motor\Backend\Models\Permission::class)->create([ 'name' => 'profile.read' ]);
        factory(Motor\Backend\Models\Permission::class)->create([ 'name' => 'profile.write' ]);
    }
}

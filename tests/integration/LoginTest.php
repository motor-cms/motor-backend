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


    public function setUp()
    {
        parent::setUp();

        create_test_permission_with_name('profile.read');
        create_test_permission_with_name('profile.write');
    }


    /** @test */
    public function user_exists_in_database()
    {
        $this->user = create_test_user();

        $this->seeInDatabase('users', [
            'email' => $this->user->email
        ]);
    }


    /** @test */
    public function user_cannot_log_in_without_password()
    {
        $this->user = create_test_user();

        $this->visit('/login')->type($this->user->email,
            'email')->press('Sign in')->see('The password field is required.');
    }


    /** @test */
    public function user_cannot_log_in_with_wrong_password()
    {
        $this->user = create_test_user();

        $this->visit('/login')->type($this->user->email, 'email')->type('wrong_password',
            'password')->press('Sign in')->see('These credentials do not match our records.');
    }


    /** @test */
    public function user_can_log_in_and_see_dashboard_as_superadmin()
    {
        $this->user = create_test_superadmin();

        $this->visit('/login')->type($this->user->email, 'email')->type('secret',
            'password')->press('Sign in')->see('Dashboard');
    }


    /** @test */
    public function user_can_log_in_and_can_see_dashboard()
    {
        $this->user = create_test_user_with_permissions([ 'dashboard.read' ]);

        $this->visit('/login')->type($this->user->email, 'email')->type('secret',
            'password')->press('Sign in')->see('Dashboard');

    }


    /**
     * @test
     */
    public function user_can_log_in_and_cannot_see_dashboard()
    {
        $this->user = create_test_user();
        create_test_permission_with_name('dashboard.read');

        try {
            $this->visit('/login')->type($this->user->email, 'email')->type('secret', 'password')->press('Sign in');
        } catch (\Exception $e) {
            $this->assertContains("Received status code [403]", $e->getMessage());
        }
    }

}

<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Motor\Backend\Models\User;

class BackendProfileTest extends TestCase
{

    use DatabaseTransactions;

    protected $user;

    protected $role;

    protected $permission;

    protected $tables = [ 'users', 'clients', 'permissions', 'user_has_permissions', 'user_has_roles', 'roles', 'media' ];


    public function setUp()
    {
        parent::setUp();

        create_test_permission_with_name('profile.read');
        create_test_permission_with_name('profile.write');
    }


    /** @test */
    public function user_can_log_in_and_see_dashboard_as_superadmin()
    {
        $this->user = create_test_superadmin();

        $this->visit('/login')
            ->type($this->user->email, 'email')
            ->type('secret', 'password')
            ->press('Sign in')
            ->see('Dashboard');
    }

    /** @test */
    public function user_can_change_password()
    {
        $this->user = create_test_superadmin();

        $this->visit('/login')
            ->type($this->user->email, 'email')
            ->type('secret', 'password')
            ->press('Sign in')
            ->see('Dashboard')
            ->within('.user-footer', function(){
                $this->click('Edit');
            })
            ->see('Edit profile')
            ->type('NewName', 'name')
            ->type('newpassword', 'password')
            ->type('newpassword', 'password_confirmation')
            ->press('Save profile');

        $this->assertEquals('NewName', $this->user->fresh()->name);
    }

    /** @test */
    public function user_can_change_password_and_log_in_with_the_new_password()
    {
        $this->user_can_change_password();

        $this->press('Sign out')
            ->seePageIs('/login')
            ->type($this->user->email, 'email')
            ->type('newpassword', 'password')
            ->press('Sign in')
            ->see('Dashboard');

    }

    /** @test */
    public function user_can_add_profile_picture()
    {
        $this->user = create_test_superadmin();

        $this->actingAs($this->user);

        $this->visit('/backend/profile/edit')
            ->attach(__DIR__ . '/../../../../public/images/motor-logo-large.png', 'avatar')
            ->press('Save profile');

        $media = $this->user->fresh()->getMedia()->first();

        $this->assertEquals('motor-logo-large.png', $media->file_name);
    }

    /** @test */
    public function user_can_add_profile_picture_and_delete_it_again()
    {
        $this->user_can_add_profile_picture();

        // We need to log out for this test to work
        $this->press('Sign out');
        $this->user = User::find($this->user->id);
        $this->actingAs($this->user);

        $this->visit('/backend/profile/edit')
            ->type('1', 'avatar_delete')
            ->press('Save profile');

        $media = $this->user->fresh()->getMedia()->first();

        $this->assertEquals(null, $media);
    }

    /** @test */
    public function user_can_change_profile_picture()
    {
        $this->user_can_add_profile_picture();

        // We need to log out for this test to work
        $this->press('Sign out');
        $this->user = User::find($this->user->id);
        $this->actingAs($this->user);

        $this->visit('/backend/profile/edit')
            ->attach(__DIR__ . '/../../../../public/images/motor-logo-small.png', 'avatar')
            ->press('Save profile');

        $media = $this->user->fresh()->getMedia()->first();

        $this->assertEquals('motor-logo-small.png', $media->file_name);
    }
}

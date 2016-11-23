<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Motor\Backend\Models\User;
use Motor\Backend\Models\Role;

class BackendUserTest extends TestCase
{

    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'users',
        'media',
        'clients',
        'languages',
        'users',
        'permissions',
        'user_has_permissions',
        'roles',
        'user_has_roles',
        'role_has_permissions'
    ];


    public function setUp()
    {
        parent::setUp();

        $this->addDefaults();
    }


    protected function addDefaults()
    {
        $this->user   = create_test_superadmin();

        $this->readPermission   = create_test_permission_with_name('users.read');
        $this->writePermission  = create_test_permission_with_name('users.write');
        $this->deletePermission = create_test_permission_with_name('users.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_with_one_users()
    {
        $this->visit('/backend/users')
            ->see('Users')
            ->see($this->user->name);
    }

    /** @test */
    public function can_see_grid_with_one_user()
    {
        $user = create_test_user();
        $this->visit('/backend/users')
            ->see('Users')
            ->see($user->name);
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_user_and_use_the_back_button()
    {
        $this->visit('/backend/users')
            ->within('table', function(){
                $this->click('Edit');
            })
            ->seePageIs('/backend/users/1/edit')
            ->click('back')
            ->seePageIs('/backend/users');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_user_and_change_values()
    {
        $user = create_test_user();

        $this->visit('/backend/users/'.$user->id.'/edit')
            ->see($user->name)
            ->type('NewUserName', 'name')
            ->within('.box-footer', function(){
                $this->press('Save user');
            })
            ->see('User updated')
            ->see('NewUserName')
            ->seePageIs('/backend/users');
    }

    /** @test */
    public function can_click_the_create_button()
    {
        $this->visit('/backend/users')
            ->click('Create user')
            ->seePageIs('/backend/users/create');
    }

    /** @test */
    public function can_create_a_new_user()
    {
        $this->visit('/backend/users/create')
            ->see('Create user')
            ->type('Username', 'name')
            ->type('test@test.de', 'email')
            ->type('secret', 'password')
            ->within('.box-footer', function(){
                $this->press('Save user');
            })
            ->see('User created')
            ->see('Username')
            ->seePageIs('/backend/users');
    }

    /** @test */
    public function can_create_a_new_user_and_assign_a_role()
    {
        $role = create_test_role();
        $this->visit('/backend/users/create')
            ->see('Create user')
            ->type('Username', 'name')
            ->type('uniqueemailaddress@test.de', 'email')
            ->type('secret', 'password')
            ->check('roles['.$role->name.']')
            ->within('.box-footer', function(){
                $this->press('Save user');
            })
            ->see('User created')
            ->see('Username')
            ->seePageIs('/backend/users');

        $user = User::where('email', 'uniqueemailaddress@test.de')->first();
        $this->assertEquals(true, $user->hasRole($role->name));
    }

    /** @test */
    public function can_edit_a_user_and_remove_a_role()
    {
        $role = create_test_role();
        $user = create_test_user();
        $user->assignRole($role);
        $this->visit('/backend/users/'.$user->id.'/edit')
            ->see('Edit user')
            ->uncheck('roles['.$role->name.']')
            ->within('.box-footer', function(){
                $this->press('Save user');
            })
            ->see('User updated')
            ->seePageIs('/backend/users');

        $updatedUser = User::find($user->id);

        $this->assertEquals(false, $updatedUser->hasRole($role->name));
    }

    /** @test */
    public function can_create_a_new_user_and_upload_an_avatar()
    {
        $this->visit('/backend/users/create')
            ->see('Create user')
            ->type('Username', 'name')
            ->type('uniqueemailaddress@test.de', 'email')
            ->type('secret', 'password')
            ->attach(__DIR__ . '/../../../../public/images/motor-logo-large.png', 'avatar')
            ->within('.box-footer', function(){
                $this->press('Save user');
            })
            ->see('User created')
            ->see('Username')
            ->seePageIs('/backend/users');

        $user = User::where('email', 'uniqueemailaddress@test.de')->first();
        $media = $user->fresh()->getMedia()->first();

        $this->assertEquals('motor-logo-large.png', $media->file_name);
    }

    /** @test */
    public function cannot_create_a_new_user_with_empty_fields()
    {
        $this->visit('/backend/users/create')
            ->see('Create user')
            ->within('.box-footer', function(){
                $this->press('Save user');
            })
            ->see('Data missing!')
            ->seePageIs('/backend/users/create');
    }

    /** @test */
    public function can_modify_a_user()
    {
        $user = create_test_user();
        $this->visit('/backend/users/'.$user->id.'/edit')
            ->see('Edit user')
            ->type('Updated Email Template Name', 'name')
            ->within('.box-footer', function(){
                $this->press('Save user');
            })
            ->see('User updated')
            ->see('Updated Email Template Name')
            ->seePageIs('/backend/users');
    }

    /** @test */
    public function can_modify_a_user_and_change_the_password()
    {
        $user = create_test_user();
        $this->visit('/backend/users/'.$user->id.'/edit')
            ->see('Edit user')
            ->type('newpassword', 'password')
            ->within('.box-footer', function(){
                $this->press('Save user');
            })
            ->see('User updated')
            ->seePageIs('/backend/users');
    }

    /** @test */
    public function can_modify_a_user_and_upload_an_avatar()
    {
        $user = create_test_user();
        $this->visit('/backend/users/'.$user->id.'/edit')
            ->see('Edit user')
            ->attach(__DIR__ . '/../../../../public/images/motor-logo-large.png', 'avatar')
            ->within('.box-footer', function(){
                $this->press('Save user');
            })
            ->see('User updated')
            ->seePageIs('/backend/users');

        $updatedUser = User::find($user->id);
        $media = $updatedUser->fresh()->getMedia()->first();

        $this->assertEquals('motor-logo-large.png', $media->file_name);

        return $updatedUser;
    }

    /** @test */
    public function can_modify_a_user_and_upload_an_avatar_and_delete_it_again()
    {
        $user = $this->can_modify_a_user_and_upload_an_avatar();

        $this->visit('/backend/users/'.$user->id.'/edit')
            ->see('Edit user')
            ->type(1, 'avatar_delete')
            ->within('.box-footer', function(){
                $this->press('Save user');
            })
            ->see('User updated')
            ->seePageIs('/backend/users');

        $updatedUser = User::find($user->id);
        $media = $updatedUser->fresh()->getMedia()->first();

        $this->assertEquals(null, $media);
    }

    /** @test */
    public function can_modify_a_user_and_change_an_avatar()
    {
        $user = $this->can_modify_a_user_and_upload_an_avatar();

        $this->visit('/backend/users/'.$user->id.'/edit')
            ->see('Edit user')
            ->attach(__DIR__ . '/../../../../public/images/motor-logo-small.png', 'avatar')
            ->within('.box-footer', function(){
                $this->press('Save user');
            })
            ->see('User updated')
            ->seePageIs('/backend/users');

        $updatedUser = User::find($user->id);
        $media = $updatedUser->fresh()->getMedia()->first();

        $this->assertEquals('motor-logo-small.png', $media->file_name);
    }

    /** @test */
    public function can_delete_a_user()
    {
        create_test_user();

        $this->assertCount(2, User::all());

        $this->visit('/backend/users')
            ->within('table', function(){
                $this->press('Delete');
            })
            ->seePageIs('/backend/users');

        $this->assertCount(1, User::all());
    }

    /** @test */
    public function can_paginate_results()
    {
        create_test_user(100);
        $this->visit('/backend/users')
            ->within('.pagination', function(){
                $this->click('3');
            })
            ->seePageIs('/backend/users?page=3');
    }

    /** @test */
    public function can_search_results()
    {
        $users = create_test_user(100);
        $this->visit('/backend/users')
            ->type(substr($users[12]->name, 0, 3), 'search')
            ->press('grid-search-button')
            ->seeInField('search', substr($users[12]->name, 0, 3))
            ->see($users[12]->name);
    }
}

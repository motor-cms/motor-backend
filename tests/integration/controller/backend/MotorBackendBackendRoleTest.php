<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Motor\Backend\Models\Role;

class MotorBackendBackendRoleTest extends TestCase
{

    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'users',
        'roles',
        'media',
        'permissions',
        'roles',
        'model_has_permissions',
        'model_has_roles',
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

        $this->readPermission   = create_test_permission_with_name('roles.read');
        $this->writePermission  = create_test_permission_with_name('roles.write');
        $this->deletePermission = create_test_permission_with_name('roles.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_with_one_role()
    {
        $this->visit('/backend/roles')
            ->see(trans('motor-backend::backend/roles.roles'))
            ->see('SuperAdmin');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_role_and_use_the_back_button()
    {
        $this->visit('/backend/roles')
            ->within('table', function(){
                $this->click(trans('motor-backend::backend/global.edit'));
            })
            ->seePageIs('/backend/roles/1/edit')
            ->click(trans('motor-backend::backend/global.back'))
            ->seePageIs('/backend/roles');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_role_and_change_the_name()
    {
        $role = create_test_role();

        $this->visit('/backend/roles/'.$role->id.'/edit')
            ->see($role->name)
            ->type('NewRole', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('motor-backend::backend/roles.save'));
            })
            ->see(trans('motor-backend::backend/roles.updated'))
            ->see('NewRole')
            ->seePageIs('/backend/roles');
    }

    /** @test */
    public function can_click_the_create_button()
    {
        $this->visit('/backend/roles')
            ->click(trans('motor-backend::backend/roles.new'))
            ->seePageIs('/backend/roles/create');
    }

    /** @test */
    public function can_create_a_new_role()
    {
        $this->visit('/backend/roles/create')
            ->see(trans('motor-backend::backend/roles.new'))
            ->type('NewRole', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('motor-backend::backend/roles.save'));
            })
            ->see(trans('motor-backend::backend/roles.created'))
            ->see('NewRole')
            ->seePageIs('/backend/roles');
    }

    /** @test */
    public function cannot_create_a_new_role_with_empty_fields()
    {
        $this->visit('/backend/roles/create')
            ->see(trans('motor-backend::backend/roles.new'))
            ->within('.box-footer', function(){
                $this->press(trans('motor-backend::backend/roles.save'));
            })
            ->see('Data missing!')
            ->seePageIs('/backend/roles/create');
    }

    /** @test */
    public function can_create_a_new_role_and_assign_one_permission()
    {
        create_test_permission_with_name('test.permission');
        create_test_permission_with_name('another.permission');

        $this->visit('/backend/roles/create')
            ->see(trans('motor-backend::backend/roles.new'))
            ->type('NewRole', 'name')
            ->check('permissions[test.permission]')
            ->within('.box-footer', function(){
                $this->press(trans('motor-backend::backend/roles.save'));
            })
            ->see(trans('motor-backend::backend/roles.created'))
            ->see('NewRole')
            ->seePageIs('/backend/roles');

        $role = Role::where('name', 'NewRole')->first();

        $this->assertEquals(true, $role->hasPermissionto('test.permission'));
        $this->assertEquals(false, $role->hasPermissionto('another.permission'));
    }

    /** @test */
    public function can_modify_a_role_and_assign_a_new_permission()
    {
        create_test_permission_with_name('test.permission');
        create_test_permission_with_name('another.permission');
        create_test_permission_with_name('third.permission');

        $role = create_test_role_with_name('TestRole');
        $role->givePermissionTo('test.permission');

        $this->visit('/backend/roles/'.$role->id.'/edit')
            ->see(trans('motor-backend::backend/roles.edit'))
            ->type('Updated role', 'name')
            ->check('permissions[another.permission]')
            ->within('.box-footer', function(){
                $this->press(trans('motor-backend::backend/roles.save'));
            })
            ->see(trans('motor-backend::backend/roles.updated'))
            ->see('Updated role')
            ->seePageIs('/backend/roles');

        $this->assertEquals(true, $role->hasPermissionto('test.permission'));
        $this->assertEquals(true, $role->hasPermissionto('another.permission'));
    }

    /** @test */
    public function can_modify_a_role_and_remove_a_permission()
    {
        create_test_permission_with_name('test.permission');
        create_test_permission_with_name('another.permission');
        create_test_permission_with_name('third.permission');

        $role = create_test_role_with_name('TestRole');
        $role->givePermissionTo('test.permission');
        $role->givePermissionTo('another.permission');

        $this->visit('/backend/roles/'.$role->id.'/edit')
            ->see(trans('motor-backend::backend/roles.edit'))
            ->type('Updated role', 'name')
            ->uncheck('permissions[test.permission]')
            ->check('permissions[another.permission]')
            ->within('.box-footer', function(){
                $this->press(trans('motor-backend::backend/roles.save'));
            })
            ->see(trans('motor-backend::backend/roles.updated'))
            ->see('Updated role')
            ->seePageIs('/backend/roles');

        $this->assertEquals(false, $role->hasPermissionto('test.permission'));
        $this->assertEquals(true, $role->hasPermissionto('another.permission'));
    }

    /** @test */
    public function can_delete_a_role()
    {
        create_test_role();
        $this->visit('/backend/roles')
            ->within('table', function(){
                $this->press(trans('motor-backend::backend/global.delete'));
            })
            ->seePageIs('/backend/roles');

        $this->assertCount(1, Role::all());
    }

    /** @test */
    public function can_paginate_results()
    {
        $roles = create_test_role(100);
        $this->visit('/backend/roles')
            ->within('.pagination', function(){
                $this->click('3');
            })
            ->seePageIs('/backend/roles?page=3');
    }

    /** @test */
    public function can_search_results()
    {
        $roles = create_test_role(100);
        $this->visit('/backend/roles')
            ->type(substr($roles[6]->name, 0, 3), 'search')
            ->press('grid-search-button')
            ->seeInField('search', substr($roles[6]->name, 0, 3))
            ->see($roles[6]->name);
    }
}

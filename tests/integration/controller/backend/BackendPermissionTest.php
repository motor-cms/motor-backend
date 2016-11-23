<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Motor\Backend\Models\Permission;
use Motor\Backend\Models\Role;

class BackendPermissionTest extends TestCase
{

    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'users',
        'roles',
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

        $this->readPermission   = create_test_permission_with_name('roles.read');
        $this->writePermission  = create_test_permission_with_name('roles.write');
        $this->deletePermission = create_test_permission_with_name('roles.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_with_one_role()
    {
        $this->visit('/backend/roles')
            ->see('Roles')
            ->see('SuperAdmin');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_permission_and_use_the_back_button()
    {
        $this->visit('/backend/permissions')
            ->within('table', function(){
                $this->click('Edit');
            })
            ->seePageIs('/backend/permissions/1/edit')
            ->click('back')
            ->seePageIs('/backend/permissions');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_permission_and_change_the_name()
    {
        $permission = create_test_permission();

        $this->visit('/backend/permissions/'.$permission->id.'/edit')
            ->see($permission->name)
            ->type('NewPermission', 'name')
            ->within('.box-footer', function(){
                $this->press('Save permission');
            })
            ->see('Permission updated')
            ->see('NewPermission')
            ->seePageIs('/backend/permissions');
    }

    /** @test */
    public function can_click_the_create_button()
    {
        $this->visit('/backend/permissions')
            ->click('Create permission')
            ->seePageIs('/backend/permissions/create');
    }

    /** @test */
    public function can_create_a_new_permission()
    {
        $this->visit('/backend/permissions/create')
            ->see('Create permission')
            ->type('NewPermission', 'name')
            ->within('.box-footer', function(){
                $this->press('Save permission');
            })
            ->see('Permission created')
            ->see('NewPermission')
            ->seePageIs('/backend/permissions');
    }

    /** @test */
    public function cannot_create_a_new_permission_with_empty_fields()
    {
        $this->visit('/backend/permissions/create')
            ->see('Create permission')
            ->within('.box-footer', function(){
                $this->press('Save permission');
            })
            ->see('Data missing!')
            ->seePageIs('/backend/permissions/create');
    }


    /** @test */
    public function can_modify_a_permission_and_change_the_permission_group()
    {
        $groups = create_test_permission_group(5);

        $permission = create_test_permission();
        $permission->permission_group_id = $groups[1]->id;
        $permission->save();

        $this->assertEquals($groups[1]->id, $permission->permission_group_id);

        $this->visit('/backend/permissions/'.$permission->id.'/edit')
            ->see('Edit permission')
            ->type('Updated permission', 'name')
            ->select($groups[3]->id, 'permission_group_id')
            ->within('.box-footer', function(){
                $this->press('Save permission');
            })
            ->see('Permission updated')
            ->see('Updated permission')
            ->seePageIs('/backend/permissions');

        $updatedPermission = Permission::find($permission->id);

        $this->assertEquals($groups[3]->id, $updatedPermission->permission_group_id);
    }

    /** @test */
    public function can_delete_a_permission()
    {
        create_test_permission();

        $this->assertCount(4, Permission::all());

        $this->visit('/backend/permissions')
            ->within('table', function(){
                $this->press('Delete');
            })
            ->seePageIs('/backend/permissions');

        $this->assertCount(3, Permission::all());
    }

    /** @test */
    public function can_paginate_results()
    {
        create_test_permission(100);
        $this->visit('/backend/permissions')
            ->within('.pagination', function(){
                $this->click('3');
            })
            ->seePageIs('/backend/permissions?page=3');
    }

    /** @test */
    public function can_search_results()
    {
        $permissions = create_test_permission(100);
        $this->visit('/backend/permissions')
            ->type(substr($permissions[23]->name, 0, 3), 'search')
            ->press('grid-search-button')
            ->seeInField('search', substr($permissions[23]->name, 0, 3))
            ->see($permissions[23]->name);
    }
}

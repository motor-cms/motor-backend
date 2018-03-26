<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Motor\Backend\Models\ConfigVariable;

class MotorBackendBackendConfigVariableTest extends TestCase
{

    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'config_variables',
        'users',
        'languages',
        'clients',
        'permissions',
        'roles',
        'model_has_permissions',
        'model_has_roles',
        'role_has_permissions',
        'media'
    ];


    public function setUp()
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../../../../database/factories');

        $this->addDefaults();
    }


    protected function addDefaults()
    {
        $this->user   = create_test_superadmin();

        $this->readPermission   = create_test_permission_with_name('config_variables.read');
        $this->writePermission  = create_test_permission_with_name('config_variables.write');
        $this->deletePermission = create_test_permission_with_name('config_variables.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_without_config_variable()
    {
        $this->visit('/backend/config_variables')
            ->see(trans('motor-backend::backend/config_variables.config_variables'))
            ->see(trans('motor-backend::backend/global.no_records'));
    }

    /** @test */
    public function can_see_grid_with_one_config_variable()
    {
        $record = create_test_config_variable();
        $this->visit('/backend/config_variables')
            ->see(trans('motor-backend::backend/config_variables.config_variables'))
            ->see($record->name);
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_config_variable_and_use_the_back_button()
    {
        $record = create_test_config_variable();
        $this->visit('/backend/config_variables')
            ->within('table', function(){
                $this->click(trans('motor-backend::backend/global.edit'));
            })
            ->seePageIs('/backend/config_variables/'.$record->id.'/edit')
            ->click(trans('motor-backend::backend/global.back'))
            ->seePageIs('/backend/config_variables');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_config_variable_and_change_values()
    {
        $record = create_test_config_variable();

        $this->visit('/backend/config_variables/'.$record->id.'/edit')
            ->see($record->name)
            ->type('Updated Config variable', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('motor-backend::backend/config_variables.save'));
            })
            ->see(trans('motor-backend::backend/config_variables.updated'))
            ->see('Updated Config variable')
            ->seePageIs('/backend/config_variables');

        $record = ConfigVariable::find($record->id);
        $this->assertEquals('Updated Config variable', $record->name);
    }

    /** @test */
    public function can_click_the_config_variable_create_button()
    {
        $this->visit('/backend/config_variables')
            ->click(trans('motor-backend::backend/config_variables.new'))
            ->seePageIs('/backend/config_variables/create');
    }

    /** @test */
    public function can_create_a_new_config_variable()
    {
        $this->visit('/backend/config_variables/create')
            ->see(trans('motor-backend::backend/config_variables.new'))
            ->type('Create Config variable Name', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('motor-backend::backend/config_variables.save'));
            })
            ->see(trans('motor-backend::backend/config_variables.created'))
            ->see('Create Config variable Name')
            ->seePageIs('/backend/config_variables');
    }

    /** @test */
    public function cannot_create_a_new_config_variable_with_empty_fields()
    {
        $this->visit('/backend/config_variables/create')
            ->see(trans('motor-backend::backend/config_variables.new'))
            ->within('.box-footer', function(){
                $this->press(trans('motor-backend::backend/config_variables.save'));
            })
            ->see('Data missing!')
            ->seePageIs('/backend/config_variables/create');
    }

    /** @test */
    public function can_modify_a_config_variable()
    {
        $record = create_test_config_variable();
        $this->visit('/backend/config_variables/'.$record->id.'/edit')
            ->see(trans('motor-backend::backend/config_variables.edit'))
            ->type('Modified Config variable Name', 'name')
            ->within('.box-footer', function(){
                $this->press(trans('motor-backend::backend/config_variables.save'));
            })
            ->see(trans('motor-backend::backend/config_variables.updated'))
            ->see('Modified Config variable Name')
            ->seePageIs('/backend/config_variables');
    }

    /** @test */
    public function can_delete_a_config_variable()
    {
        create_test_config_variable();

        $this->assertCount(1, ConfigVariable::all());

        $this->visit('/backend/config_variables')
            ->within('table', function(){
                $this->press(trans('motor-backend::backend/global.delete'));
            })
            ->seePageIs('/backend/config_variables')
            ->see(trans('motor-backend::backend/config_variables.deleted'));

        $this->assertCount(0, ConfigVariable::all());
    }

    /** @test */
    public function can_paginate_config_variable_results()
    {
        $records = create_test_config_variable(100);
        $this->visit('/backend/config_variables')
            ->within('.pagination', function(){
                $this->click('3');
            })
            ->seePageIs('/backend/config_variables?page=3');
    }

    /** @test */
    public function can_search_config_variable_results()
    {
        $records = create_test_config_variable(10);
        $this->visit('/backend/config_variables')
            ->type(substr($records[6]->name, 0, 3), 'search')
            ->press('grid-search-button')
            ->seeInField('search', substr($records[6]->name, 0, 3))
            ->see($records[6]->name);
    }
}

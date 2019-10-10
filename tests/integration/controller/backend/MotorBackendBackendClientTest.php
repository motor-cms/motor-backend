<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Motor\Backend\Models\Client;
use Motor\Backend\Models\Role;

/**
 * Class MotorBackendBackendClientTest
 */
class MotorBackendBackendClientTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'users',
        'languages',
        'clients',
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

        $this->readPermission   = create_test_permission_with_name('clients.read');
        $this->writePermission  = create_test_permission_with_name('clients.write');
        $this->deletePermission = create_test_permission_with_name('clients.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_without_clients()
    {
        $this->visit('/backend/clients')
            ->see(trans('motor-backend::backend/clients.clients'))
            ->see(trans('motor-backend::backend/global.no_records'));
    }

    /** @test */
    public function can_see_grid_with_one_client()
    {
        $client = create_test_client();
        $this->visit('/backend/clients')
            ->see(trans('motor-backend::backend/clients.clients'))
            ->see($client->name);
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_client_and_use_the_back_button()
    {
        $client = create_test_client();
        $this->visit('/backend/clients')
            ->within('table', function () {
                $this->click(trans('motor-backend::backend/global.edit'));
            })
            ->seePageIs('/backend/clients/'.$client->id.'/edit')
            ->click(trans('motor-backend::backend/global.back'))
            ->seePageIs('/backend/clients');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_client_and_change_values()
    {
        $client = create_test_client();

        $this->visit('/backend/clients/'.$client->id.'/edit')
            ->see($client->name)
            ->type('NewClientName', 'name')
            ->select('AU', 'country_iso_3166_1')
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/clients.save'));
            })
            ->see(trans('motor-backend::backend/clients.updated'))
            ->see('NewClientName')
            ->seePageIs('/backend/clients');

        $client = Client::find($client->id);
        $this->assertEquals('AU', $client->country_iso_3166_1);
    }

    /** @test */
    public function can_click_the_create_button()
    {
        $this->visit('/backend/clients')
            ->click(trans('motor-backend::backend/clients.new'))
            ->seePageIs('/backend/clients/create');
    }

    /** @test */
    public function can_create_a_new_client()
    {
        $this->visit('/backend/clients/create')
            ->see(trans('motor-backend::backend/clients.new'))
            ->type('DE', 'country_iso_3166_1')
            ->type('Client Name', 'name')
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/clients.save'));
            })
            ->see(trans('motor-backend::backend/clients.created'))
            ->see('Client Name')
            ->seePageIs('/backend/clients');
    }

    /** @test */
    public function cannot_create_a_new_client_with_empty_fields()
    {
        $this->visit('/backend/clients/create')
            ->see(trans('motor-backend::backend/clients.new'))
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/clients.save'));
            })
            ->see('Data missing!')
            ->seePageIs('/backend/clients/create');
    }

    /** @test */
    public function can_modify_a_client()
    {
        $client = create_test_client();
        $this->visit('/backend/clients/'.$client->id.'/edit')
            ->see(trans('motor-backend::backend/clients.edit'))
            ->type('Updated Client Name', 'name')
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/clients.save'));
            })
            ->see(trans('motor-backend::backend/clients.updated'))
            ->see('Updated Client Name')
            ->seePageIs('/backend/clients');
    }

    /** @test */
    public function can_delete_a_client()
    {
        create_test_client();

        $this->assertCount(1, Client::all());

        $this->visit('/backend/clients')
            ->within('table', function () {
                $this->press(trans('motor-backend::backend/global.delete'));
            })
            ->seePageIs('/backend/clients');

        $this->assertCount(0, Client::all());
    }

    /** @test */
    public function can_paginate_results()
    {
        $clients = create_test_client(100);
        $this->visit('/backend/clients')
            ->within('.pagination', function () {
                $this->click('3');
            })
            ->seePageIs('/backend/clients?page=3');
    }

    /** @test */
    public function can_search_results()
    {
        $clients = create_test_client(100);
        $this->visit('/backend/clients')
            ->type(substr($clients[6]->name, 0, 3), 'search')
            ->press('grid-search-button')
            ->seeInField('search', substr($clients[6]->name, 0, 3))
            ->see($clients[6]->name);
    }
}

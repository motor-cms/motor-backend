<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Motor\Backend\Models\EmailTemplate;
use Motor\Backend\Models\Role;

/**
 * Class MotorBackendBackendEmailTemplateTest
 */
class MotorBackendBackendEmailTemplateTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'users',
        'clients',
        'languages',
        'email_templates',
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

        $this->readPermission   = create_test_permission_with_name('email_templates.read');
        $this->writePermission  = create_test_permission_with_name('email_templates.write');
        $this->deletePermission = create_test_permission_with_name('email_templates.delete');

        $this->actingAs($this->user);
    }


    /** @test */
    public function can_see_grid_without_email_templates()
    {
        $this->visit('/backend/email_templates')
            ->see(trans('motor-backend::backend/email_templates.email_templates'))
            ->see(trans('motor-backend::backend/global.no_records'));
    }

    /** @test */
    public function can_see_grid_with_one_email_template()
    {
        $email_template = create_test_email_template();
        $this->visit('/backend/email_templates')
            ->see(trans('motor-backend::backend/email_templates.email_templates'))
            ->see($email_template->name);
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_email_template_and_use_the_back_button()
    {
        $email_template = create_test_email_template();
        $this->visit('/backend/email_templates')
            ->within('table', function () {
                $this->click(trans('motor-backend::backend/global.edit'));
            })
            ->seePageIs('/backend/email_templates/'.$email_template->id.'/edit')
            ->click(trans('motor-backend::backend/global.back'))
            ->seePageIs('/backend/email_templates');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_email_template_and_change_values()
    {
        $email_template = create_test_email_template();

        $this->visit('/backend/email_templates/'.$email_template->id.'/edit')
            ->see($email_template->name)
            ->type('NewEmailTemplateName', 'name')
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/email_templates.save'));
            })
            ->see(trans('motor-backend::backend/email_templates.updated'))
            ->see('NewEmailTemplateName')
            ->seePageIs('/backend/email_templates');
    }

    /** @test */
    public function can_click_the_create_button()
    {
        $this->visit('/backend/email_templates')
            ->click(trans('motor-backend::backend/email_templates.new'))
            ->seePageIs('/backend/email_templates/create');
    }

    /** @test */
    public function can_create_a_new_email_template()
    {
        $client = create_test_client();
        $language = create_test_language();
        $this->visit('/backend/email_templates/create')
            ->see(trans('motor-backend::backend/email_templates.new'))
            ->select($client->id, 'client_id')
            ->select($language->id, 'language_id')
            ->type('Email Template Name', 'name')
            ->type('Email Template Subject', 'subject')
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/email_templates.save'));
            })
            ->see(trans('motor-backend::backend/email_templates.created'))
            ->see('Email Template Name')
            ->seePageIs('/backend/email_templates');
    }

    /** @test */
    public function cannot_create_a_new_email_template_with_empty_fields()
    {
        $this->visit('/backend/email_templates/create')
            ->see(trans('motor-backend::backend/email_templates.new'))
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/email_templates.save'));
            })
            ->see('Data missing!')
            ->seePageIs('/backend/email_templates/create');
    }

    /** @test */
    public function can_modify_a_email_template()
    {
        $email_template = create_test_email_template();
        $this->visit('/backend/email_templates/'.$email_template->id.'/edit')
            ->see(trans('motor-backend::backend/email_templates.edit'))
            ->type('Updated Email Template Name', 'name')
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/email_templates.save'));
            })
            ->see(trans('motor-backend::backend/email_templates.updated'))
            ->see('Updated Email Template Name')
            ->seePageIs('/backend/email_templates');
    }

    /** @test */
    public function can_modify_a_email_template_and_change_client_and_language()
    {
        $email_template = create_test_email_template();
        $language = create_test_language();
        $client = create_test_client();
        $this->visit('/backend/email_templates/'.$email_template->id.'/edit')
            ->see(trans('motor-backend::backend/email_templates.edit'))
            ->select($client->id, 'client_id')
            ->select($language->id, 'language_id')
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/email_templates.save'));
            })
            ->see(trans('motor-backend::backend/email_templates.updated'))
            ->see($client->name)
            ->see($language->iso_3166_1)
            ->seePageIs('/backend/email_templates');
    }

    /** @test */
    public function can_delete_a_email_template()
    {
        create_test_email_template();

        $this->assertCount(1, EmailTemplate::all());

        $this->visit('/backend/email_templates')
            ->within('table', function () {
                $this->press(trans('motor-backend::backend/global.delete'));
            })
            ->seePageIs('/backend/email_templates');

        $this->assertCount(0, EmailTemplate::all());
    }

    /** @test */
    public function can_paginate_results()
    {
        create_test_email_template(100);
        $this->visit('/backend/email_templates')
            ->within('.pagination', function () {
                $this->click('3');
            })
            ->seePageIs('/backend/email_templates?page=3');
    }

    /** @test */
    public function can_search_results()
    {
        $email_templates = create_test_email_template(100);
        $this->visit('/backend/email_templates')
            ->type(substr($email_templates[12]->name, 0, 3), 'search')
            ->press('grid-search-button')
            ->seeInField('search', substr($email_templates[12]->name, 0, 3))
            ->see($email_templates[12]->name);
    }
}

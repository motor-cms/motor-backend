<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Motor\Backend\Models\Language;

/**
 * Class MotorBackendBackendLanguageTest
 */
class MotorBackendBackendLanguageTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'users',
        'languages',
        'permissions',
        'roles',
        'model_has_permissions',
        'model_has_roles',
        'role_has_permissions',
    ];

    protected function setUp()
    {
        parent::setUp();

        $this->addDefaults();
    }

    protected function addDefaults()
    {
        $this->user = create_test_superadmin();

        $this->readPermission = create_test_permission_with_name('languages.read');
        $this->writePermission = create_test_permission_with_name('languages.write');
        $this->deletePermission = create_test_permission_with_name('languages.delete');

        $this->actingAs($this->user);
    }

    /** @test */
    public function can_see_grid_without_languages()
    {
        $this->visit('/backend/languages')
            ->see(trans('motor-backend::backend/languages.languages'))
            ->see(trans('motor-backend::backend/global.no_records'));
    }

    /** @test */
    public function can_see_grid_with_one_language()
    {
        $language = create_test_language();
        $this->visit('/backend/languages')
            ->see(trans('motor-backend::backend/languages.languages'))
            ->see($language->english_name);
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_language_and_use_the_back_button()
    {
        $language = create_test_language();
        $this->visit('/backend/languages')
            ->within('table', function () {
                $this->click(trans('motor-backend::backend/global.edit'));
            })
            ->seePageIs('/backend/languages/'.$language->id.'/edit')
            ->click(trans('motor-backend::backend/global.back'))
            ->seePageIs('/backend/languages');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_language_and_change_values()
    {
        $language = create_test_language();

        $this->visit('/backend/languages/'.$language->id.'/edit')
            ->see($language->english_name)
            ->type('NewLanguageName', 'english_name')
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/languages.save'));
            })
            ->see(trans('motor-backend::backend/languages.updated'))
            ->see('NewLanguageName')
            ->seePageIs('/backend/languages');
    }

    /** @test */
    public function can_click_the_create_button()
    {
        $this->visit('/backend/languages')
            ->click(trans('motor-backend::backend/languages.new'))
            ->seePageIs('/backend/languages/create');
    }

    /** @test */
    public function can_create_a_new_language()
    {
        $this->visit('/backend/languages/create')
            ->see(trans('motor-backend::backend/languages.new'))
            ->type('DE', 'iso_639_1')
            ->type('Native Name', 'native_name')
            ->type('English Name', 'english_name')
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/languages.save'));
            })
            ->see(trans('motor-backend::backend/languages.created'))
            ->see('English Name')
            ->seePageIs('/backend/languages');
    }

    /** @test */
    public function cannot_create_a_new_language_with_empty_fields()
    {
        $this->visit('/backend/languages/create')
            ->see(trans('motor-backend::backend/languages.new'))
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/languages.save'));
            })
            ->see('Data missing!')
            ->seePageIs('/backend/languages/create');
    }

    /** @test */
    public function can_modify_a_language()
    {
        $language = create_test_language();
        $this->visit('/backend/languages/'.$language->id.'/edit')
            ->see(trans('motor-backend::backend/languages.edit'))
            ->type('Updated English Name', 'english_name')
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/languages.save'));
            })
            ->see(trans('motor-backend::backend/languages.updated'))
            ->see('Updated English Name')
            ->seePageIs('/backend/languages');
    }

    /** @test */
    public function can_delete_a_language()
    {
        create_test_language();

        $this->assertCount(1, Language::all());

        $this->visit('/backend/languages')
            ->within('table', function () {
                $this->press(trans('motor-backend::backend/global.delete'));
            })
            ->seePageIs('/backend/languages');

        $this->assertCount(0, Language::all());
    }

    /** @test */
    public function can_paginate_results()
    {
        create_test_language(100);
        $this->visit('/backend/languages')
            ->within('.pagination', function () {
                $this->click('3');
            })
            ->seePageIs('/backend/languages?page=3');
    }

    /** @test */
    public function can_search_results()
    {
        $languages = create_test_language(100);
        $this->visit('/backend/languages')
            ->type(substr($languages[12]->english_name, 0, 3), 'search')
            ->press('grid-search-button')
            ->seeInField('search', substr($languages[12]->english_name, 0, 3))
            ->see($languages[12]->english_name);
    }
}

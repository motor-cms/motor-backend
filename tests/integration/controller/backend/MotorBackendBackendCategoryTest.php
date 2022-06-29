<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Motor\Backend\Models\Category;

/**
 * Class MotorBackendBackendCategoryTest
 */
class MotorBackendBackendCategoryTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'categories',
        'users',
        'languages',
        'clients',
        'permissions',
        'roles',
        'model_has_permissions',
        'model_has_roles',
        'role_has_permissions',
        'media',
    ];

    public function setUp()
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../../../../database/factories');

        $this->addDefaults();
    }

    protected function addDefaults()
    {
        $this->user = create_test_superadmin();

        $this->readPermission = create_test_permission_with_name('categories.read');
        $this->writePermission = create_test_permission_with_name('categories.write');
        $this->deletePermission = create_test_permission_with_name('categories.delete');

        $this->actingAs($this->user);
    }

    /** @test */
    public function can_see_grid_without_category()
    {
        $this->visit('/backend/categories')
            ->see(trans('motor-backend::backend/categories.categories'))
            ->see(trans('motor-backend::backend/global.no_records'));
    }

    /** @test */
    public function can_see_grid_with_one_category()
    {
        $record = create_test_category();
        $this->visit('/backend/categories')
            ->see(trans('motor-backend::backend/categories.categories'))
            ->see($record->name);
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_category_and_use_the_back_button()
    {
        $record = create_test_category();
        $this->visit('/backend/categories')
            ->within('table', function () {
                $this->click(trans('motor-backend::backend/global.edit'));
            })
            ->seePageIs('/backend/categories/'.$record->id.'/edit')
            ->click(trans('motor-backend::backend/global.back'))
            ->seePageIs('/backend/categories');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_category_and_change_values()
    {
        $record = create_test_category();

        $this->visit('/backend/categories/'.$record->id.'/edit')
            ->see($record->name)
            ->type('Updated Category', 'name')
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/categories.save'));
            })
            ->see(trans('motor-backend::backend/categories.updated'))
            ->see('Updated Category')
            ->seePageIs('/backend/categories');

        $record = Category::find($record->id);
        $this->assertEquals('Updated Category', $record->name);
    }

    /** @test */
    public function can_click_the_category_create_button()
    {
        $this->visit('/backend/categories')
            ->click(trans('motor-backend::backend/categories.new'))
            ->seePageIs('/backend/categories/create');
    }

    /** @test */
    public function can_create_a_new_category()
    {
        $this->visit('/backend/categories/create')
            ->see(trans('motor-backend::backend/categories.new'))
            ->type('Create Category Name', 'name')
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/categories.save'));
            })
            ->see(trans('motor-backend::backend/categories.created'))
            ->see('Create Category Name')
            ->seePageIs('/backend/categories');
    }

    /** @test */
    public function cannot_create_a_new_category_with_empty_fields()
    {
        $this->visit('/backend/categories/create')
            ->see(trans('motor-backend::backend/categories.new'))
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/categories.save'));
            })
            ->see('Data missing!')
            ->seePageIs('/backend/categories/create');
    }

    /** @test */
    public function can_modify_a_category()
    {
        $record = create_test_category();
        $this->visit('/backend/categories/'.$record->id.'/edit')
            ->see(trans('motor-backend::backend/categories.edit'))
            ->type('Modified Category Name', 'name')
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/categories.save'));
            })
            ->see(trans('motor-backend::backend/categories.updated'))
            ->see('Modified Category Name')
            ->seePageIs('/backend/categories');
    }

    /** @test */
    public function can_delete_a_category()
    {
        create_test_category();

        $this->assertCount(1, Category::all());

        $this->visit('/backend/categories')
            ->within('table', function () {
                $this->press(trans('motor-backend::backend/global.delete'));
            })
            ->seePageIs('/backend/categories')
            ->see(trans('motor-backend::backend/categories.deleted'));

        $this->assertCount(0, Category::all());
    }

    /** @test */
    public function can_paginate_category_results()
    {
        $records = create_test_category(100);
        $this->visit('/backend/categories')
            ->within('.pagination', function () {
                $this->click('3');
            })
            ->seePageIs('/backend/categories?page=3');
    }

    /** @test */
    public function can_search_category_results()
    {
        $records = create_test_category(10);
        $this->visit('/backend/categories')
            ->type(substr($records[6]->name, 0, 3), 'search')
            ->press('grid-search-button')
            ->seeInField('search', substr($records[6]->name, 0, 3))
            ->see($records[6]->name);
    }
}

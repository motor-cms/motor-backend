<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Motor\Backend\Models\CategoryTree;

/**
 * Class MotorBackendBackendCategoryTreeTest
 */
class MotorBackendBackendCategoryTreeTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'category_trees',
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

    protected function setUp()
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../../../../database/factories');

        $this->addDefaults();
    }

    protected function addDefaults()
    {
        $this->user = create_test_superadmin();

        $this->readPermission = create_test_permission_with_name('category_trees.read');
        $this->writePermission = create_test_permission_with_name('category_trees.write');
        $this->deletePermission = create_test_permission_with_name('category_trees.delete');

        $this->actingAs($this->user);
    }

    /** @test */
    public function can_see_grid_without_category_tree()
    {
        $this->visit('/backend/category_trees')
            ->see(trans('motor-backend::backend/category_trees.category_trees'))
            ->see(trans('motor-backend::backend/global.no_records'));
    }

    /** @test */
    public function can_see_grid_with_one_category_tree()
    {
        $record = create_test_category_tree();
        $this->visit('/backend/category_trees')
            ->see(trans('motor-backend::backend/category_trees.category_trees'))
            ->see($record->name);
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_category_tree_and_use_the_back_button()
    {
        $record = create_test_category_tree();
        $this->visit('/backend/category_trees')
            ->within('table', function () {
                $this->click(trans('motor-backend::backend/global.edit'));
            })
            ->seePageIs('/backend/category_trees/'.$record->id.'/edit')
            ->click(trans('motor-backend::backend/global.back'))
            ->seePageIs('/backend/category_trees');
    }

    /** @test */
    public function can_visit_the_edit_form_of_a_category_tree_and_change_values()
    {
        $record = create_test_category_tree();

        $this->visit('/backend/category_trees/'.$record->id.'/edit')
            ->see($record->name)
            ->type('Updated Category tree', 'name')
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/category_trees.save'));
            })
            ->see(trans('motor-backend::backend/category_trees.updated'))
            ->see('Updated Category tree')
            ->seePageIs('/backend/category_trees');

        $record = CategoryTree::find($record->id);
        $this->assertEquals('Updated Category tree', $record->name);
    }

    /** @test */
    public function can_click_the_category_tree_create_button()
    {
        $this->visit('/backend/category_trees')
            ->click(trans('motor-backend::backend/category_trees.new'))
            ->seePageIs('/backend/category_trees/create');
    }

    /** @test */
    public function can_create_a_new_category_tree()
    {
        $this->visit('/backend/category_trees/create')
            ->see(trans('motor-backend::backend/category_trees.new'))
            ->type('Create Category tree Name', 'name')
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/category_trees.save'));
            })
            ->see(trans('motor-backend::backend/category_trees.created'))
            ->see('Create Category tree Name')
            ->seePageIs('/backend/category_trees');
    }

    /** @test */
    public function cannot_create_a_new_category_tree_with_empty_fields()
    {
        $this->visit('/backend/category_trees/create')
            ->see(trans('motor-backend::backend/category_trees.new'))
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/category_trees.save'));
            })
            ->see('Data missing!')
            ->seePageIs('/backend/category_trees/create');
    }

    /** @test */
    public function can_modify_a_category_tree()
    {
        $record = create_test_category_tree();
        $this->visit('/backend/category_trees/'.$record->id.'/edit')
            ->see(trans('motor-backend::backend/category_trees.edit'))
            ->type('Modified Category tree Name', 'name')
            ->within('.box-footer', function () {
                $this->press(trans('motor-backend::backend/category_trees.save'));
            })
            ->see(trans('motor-backend::backend/category_trees.updated'))
            ->see('Modified Category tree Name')
            ->seePageIs('/backend/category_trees');
    }

    /** @test */
    public function can_delete_a_category_tree()
    {
        create_test_category_tree();

        $this->assertCount(1, CategoryTree::all());

        $this->visit('/backend/category_trees')
            ->within('table', function () {
                $this->press(trans('motor-backend::backend/global.delete'));
            })
            ->seePageIs('/backend/category_trees')
            ->see(trans('motor-backend::backend/category_trees.deleted'));

        $this->assertCount(0, CategoryTree::all());
    }

    /** @test */
    public function can_paginate_category_tree_results()
    {
        $records = create_test_category_tree(100);
        $this->visit('/backend/category_trees')
            ->within('.pagination', function () {
                $this->click('3');
            })
            ->seePageIs('/backend/category_trees?page=3');
    }

    /** @test */
    public function can_search_category_tree_results()
    {
        $records = create_test_category_tree(10);
        $this->visit('/backend/category_trees')
            ->type(substr($records[6]->name, 0, 3), 'search')
            ->press('grid-search-button')
            ->seeInField('search', substr($records[6]->name, 0, 3))
            ->see($records[6]->name);
    }
}

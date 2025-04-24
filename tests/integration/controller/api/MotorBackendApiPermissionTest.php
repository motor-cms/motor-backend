<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class MotorBackendApiPermissionTest
 */
class MotorBackendApiPermissionTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [
        'users',
        'permissions',
        'model_has_permissions',
        'model_has_roles',
        'roles',
    ];

    protected function setUp()
    {
        parent::setUp();

        $this->addDefaults();
    }

    protected function addDefaults()
    {
        $this->user = create_test_user();

        $this->readPermission = create_test_permission_with_name('permissions.read');
        $this->writePermission = create_test_permission_with_name('permissions.write');
        $this->deletePermission = create_test_permission_with_name('permissions.delete');
    }

    /**
     * @test
     */
    public function returns_403_if_not_authenticated()
    {
        $this->json('GET', '/api/permissions/1')->seeStatusCode(401)->seeJson(['error' => 'Unauthenticated.']);
    }

    /** @test */
    public function returns_404_for_non_existing_record()
    {
        $this->user->givePermissionTo($this->readPermission);
        $this->json('GET', '/api/permissions/99?api_token='.$this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found',
        ]);
    }

    /** @test */
    public function fails_if_trying_to_create_without_payload()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('POST', '/api/permissions?api_token='.$this->user->api_token)->seeStatusCode(422)->seeJson([
            'name' => ['The name field is required.'],
        ]);
    }

    /** @test */
    public function fails_if_trying_to_create_without_permission()
    {
        $this->json('POST', '/api/permissions?api_token='.$this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.',
        ]);
    }

    /** @test */
    public function can_create_a_new_permission()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('POST', '/api/permissions?api_token='.$this->user->api_token, [
            'name' => 'TestPermission',
        ])->seeStatusCode(200)->seeJson([
            'name' => 'TestPermission',
        ]);
    }

    /** @test */
    public function can_create_a_new_permission_with_permission_group()
    {
        $this->user->givePermissionTo($this->writePermission);
        $permission_group = create_test_permission_group();
        $this->json('POST', '/api/permissions?api_token='.$this->user->api_token, [
            'name' => 'TestPermission',
            'permission_group_id' => $permission_group->id,
        ])->seeStatusCode(200)->seeJson([
            'name' => 'TestPermission',
            'permission_group_id' => $permission_group->id,
        ]);
    }

    /** @test */
    public function can_show_a_single_permission()
    {
        $this->user->givePermissionTo($this->readPermission);
        $permission = create_test_permission();
        $this->json(
            'GET',
            '/api/permissions/'.$permission->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(200)->seeJson([
            'name' => $permission->name,
        ]);
    }

    /** @test */
    public function fails_to_show_a_single_permission_without_permission()
    {
        $permission = create_test_permission();
        $this->json(
            'GET',
            '/api/permissions/'.$permission->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.',
        ]);
    }

    /** @test */
    public function can_show_multiple_permissions()
    {
        $this->user->givePermissionTo($this->readPermission);
        $permissions = create_test_permission(10);
        $this->json('GET', '/api/permissions?api_token='.$this->user->api_token)->seeStatusCode(200)->seeJson([
            'name' => $permissions[0]->name,
        ]);
    }

    /** @test */
    public function can_search_for_a_permission()
    {
        $this->user->givePermissionTo($this->readPermission);
        $permissions = create_test_permission(10);
        $this->json(
            'GET',
            '/api/permissions?api_token='.$this->user->api_token.'&search='.$permissions[2]->name
        )->seeStatusCode(200)->seeJson([
            'name' => $permissions[2]->name,
        ]);
    }

    /** @test */
    public function can_show_a_second_results_page()
    {
        $this->user->givePermissionTo($this->readPermission);
        create_test_permission(50);
        $this->json(
            'GET',
            '/api/permissions?api_token='.$this->user->api_token.'&page=2'
        )->seeStatusCode(200)->seeJson([
            'current_page' => 2,
        ]);
    }

    /** @test */
    public function fails_if_trying_to_update_nonexisting_permission()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('PATCH', '/api/permissions/99?api_token='.$this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found',
        ]);
    }

    /** @test */
    public function fails_if_trying_to_modify_a_permission_without_payload()
    {
        $this->user->givePermissionTo($this->writePermission);
        $permission = create_test_permission();
        $this->json(
            'PATCH',
            '/api/permissions/'.$permission->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(422)->seeJson([
            'name' => ['The name field is required.'],
        ]);
    }

    /** @test */
    public function fails_if_trying_to_modify_a_permission_without_permission()
    {
        $permission = create_test_permission();
        $this->json(
            'PATCH',
            '/api/permissions/'.$permission->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.',
        ]);
    }

    /** @test */
    public function can_modify_a_permission()
    {
        $this->user->givePermissionTo($this->writePermission);
        $permission = create_test_permission();
        $this->json('PATCH', '/api/permissions/'.$permission->id.'?api_token='.$this->user->api_token, [
            'name' => 'tests.create',
        ])->seeStatusCode(200)->seeJson([
            'name' => 'tests.create',
        ]);
    }

    /** @test */
    public function fails_if_trying_to_delete_a_non_existing_permission()
    {
        $this->user->givePermissionTo($this->deletePermission);
        $this->json('DELETE', '/api/permissions/99?api_token='.$this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found',
        ]);
    }

    /** @test */
    public function fails_to_delete_a_permission_without_permission()
    {
        $permission = create_test_permission();
        $this->json(
            'DELETE',
            '/api/permissions/'.$permission->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.',
        ]);
    }

    /** @test */
    public function can_delete_a_permission()
    {
        $this->user->givePermissionTo($this->deletePermission);
        $permission = create_test_permission();
        $this->json(
            'DELETE',
            '/api/permissions/'.$permission->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(200)->seeJson([
            'success' => true,
        ]);
    }
}

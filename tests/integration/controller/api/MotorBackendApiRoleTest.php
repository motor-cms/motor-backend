<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class MotorBackendApiRoleTest
 */
class MotorBackendApiRoleTest extends TestCase
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
        $this->user = create_test_user();

        $this->readPermission = create_test_permission_with_name('roles.read');
        $this->writePermission = create_test_permission_with_name('roles.write');
        $this->deletePermission = create_test_permission_with_name('roles.delete');
    }

    /**
     * @test
     */
    public function returns_403_if_not_authenticated()
    {
        $this->json('GET', '/api/roles/1')->seeStatusCode(401)->seeJson(['error' => 'Unauthenticated.']);
    }

    /** @test */
    public function returns_404_for_non_existing_record()
    {
        $this->user->givePermissionTo($this->readPermission);
        $this->json('GET', '/api/roles/1?api_token='.$this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found',
        ]);
    }

    /** @test */
    public function fails_if_trying_to_create_without_payload()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('POST', '/api/roles?api_token='.$this->user->api_token)->seeStatusCode(422)->seeJson([
            'name' => ['The name field is required.'],
        ]);
    }

    /** @test */
    public function fails_if_trying_to_create_without_permission()
    {
        $this->json('POST', '/api/roles?api_token='.$this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.',
        ]);
    }

    /** @test */
    public function can_create_a_new_role()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('POST', '/api/roles?api_token='.$this->user->api_token, [
            'name' => 'TestRole',
        ])->seeStatusCode(200)->seeJson([
            'name' => 'TestRole',
        ]);
    }

    /** @test */
    public function can_create_a_new_role_with_permissions()
    {
        $this->user->givePermissionTo($this->writePermission);
        $permissions = create_test_permission(5);
        $this->json('POST', '/api/roles?api_token='.$this->user->api_token, [
            'name' => 'TestRole',
            'permissions' => [
                $permissions[0]->name => 1,
                $permissions[1]->name => 1,
                $permissions[2]->name => 1,
                $permissions[3]->name => 1,
            ],
        ])->seeStatusCode(200)->seeJson([
            'name' => 'TestRole',
        ])->seeJson([
            'name' => $permissions[0]->name,
        ])->seeJson([
            'name' => $permissions[1]->name,
        ])->seeJson([
            'name' => $permissions[2]->name,
        ])->seeJson([
            'name' => $permissions[3]->name,
        ]);
    }

    /** @test */
    public function can_show_a_single_role()
    {
        $this->user->givePermissionTo($this->readPermission);
        $role = create_test_role();
        $this->json(
            'GET',
            '/api/roles/'.$role->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(200)->seeJson([
            'name' => $role->name,
        ]);
    }

    /** @test */
    public function fails_to_show_a_single_role_without_permission()
    {
        $role = create_test_role();
        $this->json(
            'GET',
            '/api/roles/'.$role->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.',
        ]);
    }

    /** @test */
    public function can_get_empty_result_when_trying_to_show_multiple_roles()
    {
        $this->user->givePermissionTo($this->readPermission);
        $this->json('GET', '/api/roles?api_token='.$this->user->api_token)->seeStatusCode(200)->seeJson([
            'total' => 0,
        ]);
    }

    /** @test */
    public function can_show_multiple_roles()
    {
        $this->user->givePermissionTo($this->readPermission);
        $roles = create_test_role(10);
        $this->json('GET', '/api/roles?api_token='.$this->user->api_token)->seeStatusCode(200)->seeJson([
            'name' => $roles[0]->name,
        ]);
    }

    /** @test */
    public function can_search_for_a_role()
    {
        $this->user->givePermissionTo($this->readPermission);
        $roles = create_test_role(10);
        $this->json(
            'GET',
            '/api/roles?api_token='.$this->user->api_token.'&search='.$roles[2]->name
        )->seeStatusCode(200)->seeJson([
            'name' => $roles[2]->name,
        ]);
    }

    /** @test */
    public function can_show_a_second_results_page()
    {
        $this->user->givePermissionTo($this->readPermission);
        create_test_role(50);
        $this->json('GET', '/api/roles?api_token='.$this->user->api_token.'&page=2')->seeStatusCode(200)->seeJson([
            'current_page' => 2,
        ]);
    }

    /** @test */
    public function fails_if_trying_to_update_nonexisting_role()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('PATCH', '/api/roles/2?api_token='.$this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found',
        ]);
    }

    /** @test */
    public function fails_if_trying_to_modify_a_role_without_payload()
    {
        $this->user->givePermissionTo($this->writePermission);
        $role = create_test_role();
        $this->json(
            'PATCH',
            '/api/roles/'.$role->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(422)->seeJson([
            'name' => ['The name field is required.'],
        ]);
    }

    /** @test */
    public function fails_if_trying_to_modify_a_role_without_permission()
    {
        $role = create_test_role();
        $this->json(
            'PATCH',
            '/api/roles/'.$role->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.',
        ]);
    }

    /** @test */
    public function can_modify_a_role()
    {
        $this->user->givePermissionTo($this->writePermission);
        $role = create_test_role();
        $this->json('PATCH', '/api/roles/'.$role->id.'?api_token='.$this->user->api_token, [
            'name' => 'TestRole',
        ])->seeStatusCode(200)->seeJson([
            'name' => 'TestRole',
        ]);
    }

    /** @test */
    public function fails_if_trying_to_delete_a_non_existing_role()
    {
        $this->user->givePermissionTo($this->deletePermission);
        $this->json('DELETE', '/api/roles/1?api_token='.$this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found',
        ]);
    }

    /** @test */
    public function fails_to_delete_a_role_without_permission()
    {
        $role = create_test_role();
        $this->json(
            'DELETE',
            '/api/roles/'.$role->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.',
        ]);
    }

    /** @test */
    public function can_delete_a_role()
    {
        $this->user->givePermissionTo($this->deletePermission);
        $role = create_test_role();
        $this->json(
            'DELETE',
            '/api/roles/'.$role->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(200)->seeJson([
            'success' => true,
        ]);
    }
}

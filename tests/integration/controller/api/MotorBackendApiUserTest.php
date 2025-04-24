<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class MotorBackendApiUserTest
 */
class MotorBackendApiUserTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $writeRolePermission;

    protected $writePermissionPermission;

    protected $tables = [
        'users',
        'media',
        'clients',
        'languages',
        'users',
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

        $this->readPermission = create_test_permission_with_name('users.read');
        $this->writePermission = create_test_permission_with_name('users.write');
        $this->deletePermission = create_test_permission_with_name('users.delete');

        $this->writeRolePermission = create_test_permission_with_name('roles.write');
        $this->writePermissionPermission = create_test_permission_with_name('permissions.write');
    }

    /**
     * @test
     */
    public function returns_403_if_not_authenticated()
    {
        $this->json('GET', '/api/users/99')->seeStatusCode(401)->seeJson(['error' => 'Unauthenticated.']);
    }

    /** @test */
    public function returns_404_for_non_existing_record()
    {
        $this->user->givePermissionTo($this->readPermission);
        $this->json('GET', '/api/users/99?api_token='.$this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found',
        ]);
    }

    /** @test */
    public function fails_if_trying_to_create_without_payload()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('POST', '/api/users?api_token='.$this->user->api_token)->seeStatusCode(422)->seeJson([
            'name' => ['The name field is required.'],
        ]);
    }

    /** @test */
    public function fails_if_trying_to_create_without_permission()
    {
        $this->json('POST', '/api/users?api_token='.$this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.',
        ]);
    }

    /** @test */
    public function can_create_a_new_user()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('POST', '/api/users?api_token='.$this->user->api_token, [
            'name' => 'TestUser',
            'email' => 'test@test.de',
            'password' => 'secret',
        ])->seeStatusCode(200)->seeJson([
            'name' => 'TestUser',
        ]);
    }

    /** @test */
    public function cannot_create_a_new_user_with_permissions()
    {
        $this->user->givePermissionTo($this->writePermission);
        $permissions = create_test_permission(5);
        $this->json('POST', '/api/users?api_token='.$this->user->api_token, [
            'name' => 'Testuser',
            'email' => 'test@test.de',
            'password' => 'secret',
            'permissions' => [
                $permissions[0]->name => 1,
                $permissions[1]->name => 1,
                $permissions[2]->name => 1,
                $permissions[3]->name => 1,
            ],
        ])->seeStatusCode(200)->seeJson([
            'name' => 'Testuser',
        ])->dontSeeJson([
            'name' => $permissions[0]->name,
        ])->dontSeeJson([
            'name' => $permissions[1]->name,
        ])->dontSeeJson([
            'name' => $permissions[2]->name,
        ])->dontSeeJson([
            'name' => $permissions[3]->name,
        ]);
    }

    /** @test */
    public function can_create_a_new_user_with_permissions()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->user->givePermissionTo($this->writePermissionPermission);
        $permissions = create_test_permission(5);
        $this->json('POST', '/api/users?api_token='.$this->user->api_token, [
            'name' => 'Testuser',
            'email' => 'test@test.de',
            'password' => 'secret',
            'permissions' => [
                $permissions[0]->name => 1,
                $permissions[1]->name => 1,
                $permissions[2]->name => 1,
                $permissions[3]->name => 1,
            ],
        ])->seeStatusCode(200)->seeJson([
            'name' => 'Testuser',
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
    public function cannot_create_a_new_user_with_roles()
    {
        $this->user->givePermissionTo($this->writePermission);
        $roles = create_test_role(2);
        $this->json('POST', '/api/users?api_token='.$this->user->api_token, [
            'name' => 'Testuser',
            'email' => 'test@test.de',
            'password' => 'secret',
            'roles' => [
                $roles[0]->name => 1,
                $roles[1]->name => 1,
            ],
        ])->seeStatusCode(200)->seeJson([
            'name' => 'Testuser',
        ])->dontSeeJson([
            'name' => $roles[0]->name,
        ])->dontSeeJson([
            'name' => $roles[1]->name,
        ]);
    }

    /** @test */
    public function can_create_a_new_user_with_roles()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->user->givePermissionTo($this->writeRolePermission);
        $roles = create_test_role(2);
        $this->json('POST', '/api/users?api_token='.$this->user->api_token, [
            'name' => 'Testuser',
            'email' => 'test@test.de',
            'password' => 'secret',
            'roles' => [
                $roles[0]->name => 1,
                $roles[1]->name => 1,
            ],
        ])->seeStatusCode(200)->seeJson([
            'name' => 'Testuser',
        ])->seeJson([
            'name' => $roles[0]->name,
        ])->seeJson([
            'name' => $roles[1]->name,
        ]);
    }

    /** @test */
    public function can_modify_a_user_with_roles()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->user->givePermissionTo($this->writeRolePermission);
        $user = create_test_user();
        $roles = create_test_role(2);
        $this->json('PATCH', '/api/users/'.$user->id.'?api_token='.$this->user->api_token, [
            'name' => 'Testuser',
            'email' => 'test@test.de',
            'password' => 'secret',
            'roles' => [
                $roles[0]->name => 1,
                $roles[1]->name => 1,
            ],
        ])->seeStatusCode(200)->seeJson([
            'name' => 'Testuser',
        ])->seeJson([
            'name' => $roles[0]->name,
        ])->seeJson([
            'name' => $roles[1]->name,
        ]);
    }

    /** @test */
    public function can_modify_a_user_with_permissions()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->user->givePermissionTo($this->writePermissionPermission);
        $user = create_test_user();
        $permissions = create_test_permission(5);
        $this->json('PATCH', '/api/users/'.$user->id.'?api_token='.$this->user->api_token, [
            'name' => 'Testuser',
            'email' => 'test@test.de',
            'password' => 'secret',
            'permissions' => [
                $permissions[0]->name => 1,
                $permissions[1]->name => 1,
                $permissions[2]->name => 1,
                $permissions[3]->name => 1,
            ],
        ])->seeStatusCode(200)->seeJson([
            'name' => 'Testuser',
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
    public function can_show_a_single_user()
    {
        $this->user->givePermissionTo($this->readPermission);
        $user = create_test_user();
        $this->json(
            'GET',
            '/api/users/'.$user->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(200)->seeJson([
            'name' => $user->name,
        ]);
    }

    /** @test */
    public function fails_to_show_a_single_user_without_permission()
    {
        $user = create_test_user();
        $this->json(
            'GET',
            '/api/users/'.$user->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.',
        ]);
    }

    /** @test */
    public function can_show_multiple_users()
    {
        $this->user->givePermissionTo($this->readPermission);
        $users = factory(Motor\Backend\Models\User::class, 10)->create();
        $this->json('GET', '/api/users?api_token='.$this->user->api_token)->seeStatusCode(200)->seeJson([
            'name' => $users[0]->name,
        ]);
    }

    /** @test */
    public function can_search_for_a_user()
    {
        $this->user->givePermissionTo($this->readPermission);
        $users = create_test_user(10);
        $this->json(
            'GET',
            '/api/users?api_token='.$this->user->api_token.'&search='.$users[2]->name
        )->seeStatusCode(200)->seeJson([
            'name' => $users[2]->name,
        ]);
    }

    /** @test */
    public function can_show_a_second_results_page()
    {
        $this->user->givePermissionTo($this->readPermission);
        create_test_user(50);
        $this->json('GET', '/api/users?api_token='.$this->user->api_token.'&page=2')->seeStatusCode(200)->seeJson([
            'current_page' => 2,
        ]);
    }

    /** @test */
    public function fails_if_trying_to_update_nonexisting_user()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('PATCH', '/api/users/99?api_token='.$this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found',
        ]);
    }

    /** @test */
    public function fails_if_trying_to_modify_a_user_without_payload()
    {
        $this->user->givePermissionTo($this->writePermission);
        $user = create_test_user();
        $this->json(
            'PATCH',
            '/api/users/'.$user->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(422)->seeJson([
            'name' => ['The name field is required.'],
        ]);
    }

    /** @test */
    public function fails_if_trying_to_modify_a_user_without_permission()
    {
        $user = create_test_user();
        $this->json(
            'PATCH',
            '/api/users/'.$user->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.',
        ]);
    }

    /** @test */
    public function can_modify_a_user()
    {
        $this->user->givePermissionTo($this->writePermission);
        $user = create_test_user();
        $this->json('PATCH', '/api/users/'.$user->id.'?api_token='.$this->user->api_token, [
            'name' => 'TestName',
            'email' => $user->email,
        ])->seeStatusCode(200)->seeJson([
            'name' => 'TestName',
        ]);
    }

    /** @test */
    public function can_modify_a_user_and_upload_image()
    {
        $this->user->givePermissionTo($this->writePermission);
        $user = create_test_user();
        $this->json('PATCH', '/api/users/'.$user->id.'?api_token='.$this->user->api_token, [
            'name' => 'TestName',
            'email' => $user->email,
            'avatar' => base64_encode(file_get_contents(__DIR__.'/../../../../public/images/motor-logo-large.png')),
        ])->seeStatusCode(200)->seeJson([
            'name' => 'TestName',
            'collection' => 'avatar',
        ]);
    }

    /** @test */
    public function can_modify_a_user_and_upload_image_and_set_custom_filename()
    {
        $this->user->givePermissionTo($this->writePermission);
        $user = create_test_user();
        $this->json('PATCH', '/api/users/'.$user->id.'?api_token='.$this->user->api_token, [
            'name' => 'TestName',
            'email' => $user->email,
            'avatar' => base64_encode(file_get_contents(__DIR__.'/../../../../public/images/motor-logo-large.png')),
            'avatar_name' => 'custom_filename.png',
        ])->seeStatusCode(200)->seeJson([
            'name' => 'TestName',
            'collection' => 'avatar',
            'file_name' => 'custom_filename.png',
        ]);
    }

    /** @test */
    public function can_modify_a_user_and_upload_image_and_delete_it_again()
    {
        $this->user->givePermissionTo($this->writePermission);
        $user = create_test_user();
        $this->json('PATCH', '/api/users/'.$user->id.'?api_token='.$this->user->api_token, [
            'name' => 'TestName',
            'email' => $user->email,
            'avatar' => base64_encode(file_get_contents(__DIR__.'/../../../../public/images/motor-logo-large.png')),
        ])->seeStatusCode(200)->seeJson([
            'name' => 'TestName',
            'collection' => 'avatar',
        ]);

        $this->json('PATCH', '/api/users/'.$user->id.'?api_token='.$this->user->api_token, [
            'name' => 'TestName',
            'email' => $user->email,
            'avatar_delete' => 1,
        ])->seeStatusCode(200)->dontSeeJson([
            'collection' => 'avatar',
        ]);
    }

    /** @test */
    public function fails_if_trying_to_delete_a_non_existing_user()
    {
        $this->user->givePermissionTo($this->deletePermission);
        $this->json('DELETE', '/api/users/99?api_token='.$this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found',
        ]);
    }

    /** @test */
    public function fails_to_delete_a_user_without_permission()
    {
        $user = create_test_user();
        $this->json(
            'DELETE',
            '/api/users/'.$user->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.',
        ]);
    }

    /** @test */
    public function can_delete_a_user()
    {
        $this->user->givePermissionTo($this->deletePermission);
        $user = create_test_user();
        $this->json(
            'DELETE',
            '/api/users/'.$user->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(200)->seeJson([
            'success' => true,
        ]);
    }
}

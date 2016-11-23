<?php

// TODO: make sure the permission to add/edit roles and permissions for users are given
// TODO: test file upload
// TODO: test file deletion

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{

    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [ 'users', 'permissions', 'user_has_permissions', 'user_has_roles' ];


    public function setUp()
    {
        parent::setUp();

        $this->addDefaults();
    }


    protected function addDefaults()
    {
        $this->user = factory(Motor\Backend\Models\User::class)->create();

        $this->readPermission   = factory(Motor\Backend\Models\Permission::class)->create([ 'name' => 'users.read' ]);
        $this->writePermission  = factory(Motor\Backend\Models\Permission::class)->create([ 'name' => 'users.write' ]);
        $this->deletePermission = factory(Motor\Backend\Models\Permission::class)->create([ 'name' => 'users.delete' ]);
    }


    /**
     * @test
     */
    public function returns_403_if_not_authenticated()
    {
        $this->json('GET', '/api/users/99')->seeStatusCode(401)->seeJson([ 'error' => 'Unauthenticated.' ]);
    }


    /** @test */
    public function returns_404_for_non_existing_record()
    {
        $this->user->givePermissionTo($this->readPermission);
        $this->json('GET', '/api/users/99?api_token=' . $this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found',
        ]);
    }


    /** @test */
    public function fails_if_trying_to_create_without_payload()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('POST', '/api/users?api_token=' . $this->user->api_token)->seeStatusCode(422)->seeJson([
            'name' => [ "The name field is required." ]
        ]);
    }


    /** @test */
    public function fails_if_trying_to_create_without_permission()
    {
        $this->json('POST', '/api/users?api_token=' . $this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => "Access denied."
        ]);
    }


    /** @test */
    public function can_create_a_new_user()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('POST', '/api/users?api_token=' . $this->user->api_token, [
            'name'     => 'TestUser',
            'email'    => 'test@test.de',
            'password' => 'secret'
        ])->seeStatusCode(200)->seeJson([
            'name' => 'TestUser'
        ]);
    }


    /** @test */
    public function can_create_a_new_user_with_permissions()
    {
        $this->user->givePermissionTo($this->writePermission);
        $permissions = factory(Motor\Backend\Models\Permission::class, 5)->create();
        $this->json('POST', '/api/users?api_token=' . $this->user->api_token, [
            'name'        => 'Testuser',
            'email'       => 'test@test.de',
            'password'    => 'secret',
            'permissions' => [
                $permissions[0]->name => 1,
                $permissions[1]->name => 1,
                $permissions[2]->name => 1,
                $permissions[3]->name => 1,
            ]
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
    public function can_create_a_new_user_with_roles()
    {
        $this->user->givePermissionTo($this->writePermission);
        $roles = factory(Motor\Backend\Models\Role::class, 2)->create();
        $this->json('POST', '/api/users?api_token=' . $this->user->api_token, [
            'name'        => 'Testuser',
            'email'       => 'test@test.de',
            'password'    => 'secret',
            'roles' => [
                $roles[0]->name => 1,
                $roles[1]->name => 1
            ]
        ])->seeStatusCode(200)->seeJson([
            'name' => 'Testuser',
        ])->seeJson([
            'name' => $roles[0]->name,
        ])->seeJson([
            'name' => $roles[1]->name,
        ]);
    }

    /** @test */
    public function can_show_a_single_user()
    {
        $this->user->givePermissionTo($this->readPermission);
        $user = factory(Motor\Backend\Models\User::class)->create();
        $this->json('GET',
            '/api/users/' . $user->id . '?api_token=' . $this->user->api_token)->seeStatusCode(200)->seeJson([
            'name' => $user->name
        ]);
    }


    /** @test */
    public function fails_to_show_a_single_user_without_permission()
    {
        $user = factory(Motor\Backend\Models\User::class)->create();
        $this->json('GET',
            '/api/users/' . $user->id . '?api_token=' . $this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.'
        ]);
    }


    /** @test */
    public function can_show_multiple_users()
    {
        $this->user->givePermissionTo($this->readPermission);
        $users = factory(Motor\Backend\Models\User::class, 10)->create();
        $this->json('GET', '/api/users?api_token=' . $this->user->api_token)->seeStatusCode(200)->seeJson([
            'name' => $users[0]->name
        ]);
    }


    /** @test */
    public function can_search_for_a_user()
    {
        $this->user->givePermissionTo($this->readPermission);
        $users = factory(Motor\Backend\Models\User::class, 10)->create();
        $this->json('GET',
            '/api/users?api_token=' . $this->user->api_token . '&search=' . $users[2]->name)->seeStatusCode(200)->seeJson([
            'name' => $users[2]->name
        ]);
    }


    /** @test */
    public function can_show_a_second_results_page()
    {
        $this->user->givePermissionTo($this->readPermission);
        factory(Motor\Backend\Models\User::class, 50)->create();
        $this->json('GET', '/api/users?api_token=' . $this->user->api_token . '&page=2')->seeStatusCode(200)->seeJson([
            'current_page' => 2
        ]);
    }


    /** @test */
    public function fails_if_trying_to_update_nonexisting_user()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('PATCH', '/api/users/99?api_token=' . $this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found'
        ]);
    }


    /** @test */
    public function fails_if_trying_to_modify_a_user_without_payload()
    {
        $this->user->givePermissionTo($this->writePermission);
        $user = factory(Motor\Backend\Models\User::class)->create();
        $this->json('PATCH',
            '/api/users/' . $user->id . '?api_token=' . $this->user->api_token)->seeStatusCode(422)->seeJson([
            'name' => [ 'The name field is required.' ]
        ]);
    }


    /** @test */
    public function fails_if_trying_to_modify_a_user_without_permission()
    {
        $user = factory(Motor\Backend\Models\User::class)->create();
        $this->json('PATCH',
            '/api/users/' . $user->id . '?api_token=' . $this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.'
        ]);
    }


    /** @test */
    public function can_modify_a_user()
    {
        $this->user->givePermissionTo($this->writePermission);
        $user = factory(Motor\Backend\Models\User::class)->create();
        $this->json('PATCH', '/api/users/' . $user->id . '?api_token=' . $this->user->api_token, [
            'name'  => 'TestName',
            'email' => $user->email
        ])->seeStatusCode(200)->seeJson([
            'name' => 'TestName'
        ]);
    }


    /** @test */
    public function fails_if_trying_to_delete_a_non_existing_user()
    {
        $this->user->givePermissionTo($this->deletePermission);
        $this->json('DELETE', '/api/users/99?api_token=' . $this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found'
        ]);
    }


    /** @test */
    public function fails_to_delete_a_user_without_permission()
    {
        $user = factory(Motor\Backend\Models\User::class)->create();
        $this->json('DELETE',
            '/api/users/' . $user->id . '?api_token=' . $this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.'
        ]);
    }


    /** @test */
    public function can_delete_a_user()
    {
        $this->user->givePermissionTo($this->deletePermission);
        $user = factory(Motor\Backend\Models\User::class)->create();
        $this->json('DELETE',
            '/api/users/' . $user->id . '?api_token=' . $this->user->api_token)->seeStatusCode(200)->seeJson([
            'success' => true
        ]);
    }
}

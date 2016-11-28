<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MotorBackendApiClientTest extends TestCase
{

    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [ 'users', 'clients', 'permissions', 'user_has_permissions', 'user_has_roles', 'roles' ];


    public function setUp()
    {
        parent::setUp();

        $this->addDefaults();
    }


    protected function addDefaults()
    {
        $this->user = create_test_user();
        $this->readPermission = create_test_permission_with_name('clients.read');
        $this->writePermission = create_test_permission_with_name('clients.write');
        $this->deletePermission = create_test_permission_with_name('clients.delete');
    }


    /**
     * @test
     */
    public function returns_403_if_not_authenticated()
    {
        $this->json('GET', '/api/clients/1')->seeStatusCode(401)->seeJson([ 'error' => 'Unauthenticated.' ]);
    }


    /** @test */
    public function returns_404_for_non_existing_client_record()
    {
        $this->user->givePermissionTo($this->readPermission);
        $this->json('GET', '/api/clients/1?api_token=' . $this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found',
        ]);
    }


    /** @test */
    public function fails_if_trying_to_create_without_payload()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('POST', '/api/clients?api_token=' . $this->user->api_token)->seeStatusCode(422)->seeJson([
            'name' => [ "The name field is required." ]
        ]);
    }


    /** @test */
    public function fails_if_trying_to_create_without_permission()
    {
        $this->json('POST', '/api/clients?api_token=' . $this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => "Access denied."
        ]);
    }


    /** @test */
    public function can_create_a_new_client()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('POST', '/api/clients?api_token=' . $this->user->api_token, [
            'name' => 'TestClient'
        ])->seeStatusCode(200)->seeJson([
            'name' => 'TestClient'
        ]);
    }


    /** @test */
    public function can_show_a_single_client()
    {
        $this->user->givePermissionTo($this->readPermission);
        $client = create_test_client();
        $this->json('GET',
            '/api/clients/' . $client->id . '?api_token=' . $this->user->api_token)->seeStatusCode(200)->seeJson([
            'name' => $client->name
        ]);
    }

    /** @test */
    public function fails_to_show_a_single_client_without_permission()
    {
        $client = factory(Motor\Backend\Models\Client::class)->create();
        $this->json('GET',
            '/api/clients/' . $client->id . '?api_token=' . $this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.'
        ]);
    }

    /** @test */
    public function can_get_empty_result_when_trying_to_show_multiple_clients()
    {
        $this->user->givePermissionTo($this->readPermission);
        $this->json('GET', '/api/clients?api_token=' . $this->user->api_token)->seeStatusCode(200)->seeJson([
            'total' => 0
        ]);
    }


    /** @test */
    public function can_show_multiple_clients()
    {
        $this->user->givePermissionTo($this->readPermission);
        $clients = create_test_client(10);
        $this->json('GET', '/api/clients?api_token=' . $this->user->api_token)->seeStatusCode(200)->seeJson([
            'name' => $clients[0]->name
        ]);
    }


    /** @test */
    public function can_search_for_a_client()
    {
        $this->user->givePermissionTo($this->readPermission);
        $clients = create_test_client(10);
        $this->json('GET',
            '/api/clients?api_token=' . $this->user->api_token . '&search=' . $clients[2]->name)->seeStatusCode(200)->seeJson([
            'name' => $clients[2]->name
        ]);
    }


    /** @test */
    public function can_show_a_second_results_page()
    {
        $this->user->givePermissionTo($this->readPermission);
        create_test_client(50);
        $this->json('GET',
            '/api/clients?api_token=' . $this->user->api_token . '&page=2')->seeStatusCode(200)->seeJson([
            'current_page' => 2
        ]);
    }


    /** @test */
    public function fails_if_trying_to_update_nonexisting_client()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('PATCH', '/api/clients/2?api_token=' . $this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found'
        ]);
    }


    /** @test */
    public function fails_if_trying_to_modify_a_client_without_payload()
    {
        $this->user->givePermissionTo($this->writePermission);
        $client = create_test_client();
        $this->json('PATCH',
            '/api/clients/' . $client->id . '?api_token=' . $this->user->api_token)->seeStatusCode(422)->seeJson([
            'name' => [ 'The name field is required.' ]
        ]);
    }


    /** @test */
    public function fails_if_trying_to_modify_a_client_without_permission()
    {
        $client = create_test_client();
        $this->json('PATCH',
            '/api/clients/' . $client->id . '?api_token=' . $this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.'
        ]);
    }

    /** @test */
    public function can_modify_a_client()
    {
        $this->user->givePermissionTo($this->writePermission);
        $client = create_test_client();
        $this->json('PATCH', '/api/clients/' . $client->id . '?api_token=' . $this->user->api_token, [
            'name' => $client->name,
            'city' => 'Saarbrücken'
        ])->seeStatusCode(200)->seeJson([
            'city' => 'Saarbrücken'
        ]);
    }


    /** @test */
    public function fails_if_trying_to_delete_a_non_existing_client()
    {
        $this->user->givePermissionTo($this->deletePermission);
        $this->json('DELETE', '/api/clients/1?api_token=' . $this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found'
        ]);
    }


    /** @test */
    public function fails_to_delete_a_client_without_permission()
    {
        $client = factory(Motor\Backend\Models\Client::class)->create();
        $this->json('DELETE',
            '/api/clients/' . $client->id . '?api_token=' . $this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.'
        ]);
    }

    /** @test */
    public function can_delete_a_client()
    {
        $this->user->givePermissionTo($this->deletePermission);
        $client = create_test_client();
        $this->json('DELETE',
            '/api/clients/' . $client->id . '?api_token=' . $this->user->api_token)->seeStatusCode(200)->seeJson([
            'success' => true
        ]);
    }
}

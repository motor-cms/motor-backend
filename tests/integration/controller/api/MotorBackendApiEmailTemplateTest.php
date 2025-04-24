<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class MotorBackendApiEmailTemplateTest
 */
class MotorBackendApiEmailTemplateTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected $client;

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
        $this->client = create_test_client();

        $this->readPermission = create_test_permission_with_name('email_templates.read');
        $this->writePermission = create_test_permission_with_name('email_templates.write');
        $this->deletePermission = create_test_permission_with_name('email_templates.delete');
    }

    /**
     * @test
     */
    public function returns_403_if_not_authenticated()
    {
        $this->json('GET', '/api/email_templates/1')->seeStatusCode(401)->seeJson(['error' => 'Unauthenticated.']);
    }

    /** @test */
    public function returns_404_for_non_existing_record()
    {
        $this->user->givePermissionTo($this->readPermission);
        $this->json('GET', '/api/email_templates/1?api_token='.$this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found',
        ]);
    }

    /** @test */
    public function fails_if_trying_to_create_without_payload()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('POST', '/api/email_templates?api_token='.$this->user->api_token)->seeStatusCode(422)->seeJson([
            'client_id' => ['The client id field is required.'],
        ]);
    }

    /** @test */
    public function fails_if_trying_to_create_without_permission()
    {
        $this->json('POST', '/api/email_templates?api_token='.$this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.',
        ]);
    }

    /** @test */
    public function can_create_a_new_email_template()
    {
        $this->user->givePermissionTo($this->writePermission);
        $language = create_test_language();
        $this->json('POST', '/api/email_templates?api_token='.$this->user->api_token, [
            'client_id' => $this->client->id,
            'language_id' => $language->id,
            'name' => 'Test',
            'subject' => 'Test',
        ])->seeStatusCode(200)->seeJson([
            'name' => 'Test',
        ]);
    }

    /** @test */
    public function can_show_a_single_email_template()
    {
        $this->user->givePermissionTo($this->readPermission);
        $email_template = create_test_email_template();
        $this->json(
            'GET',
            '/api/email_templates/'.$email_template->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(200)->seeJson([
            'body_html' => $email_template->body_html,
        ]);
    }

    /** @test */
    public function fails_to_show_a_single_email_template_without_permission()
    {
        $email_template = create_test_email_template();
        $this->json(
            'GET',
            '/api/email_template/'.$email_template->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.',
        ]);
    }

    /** @test */
    public function can_get_empty_result_when_trying_to_show_multiple_email_templates()
    {
        $this->user->givePermissionTo($this->readPermission);
        $this->json('GET', '/api/email_templates?api_token='.$this->user->api_token)->seeStatusCode(200)->seeJson([
            'total' => 0,
        ]);
    }

    /** @test */
    public function can_show_multiple_email_templates()
    {
        $this->user->givePermissionTo($this->readPermission);
        $email_templates = factory(Motor\Backend\Models\EmailTemplate::class, 10)->create();
        $this->json('GET', '/api/email_templates?api_token='.$this->user->api_token)->seeStatusCode(200)->seeJson([
            'subject' => $email_templates[0]->subject,
        ]);
    }

    /** @test */
    public function can_search_for_an_email_template()
    {
        $this->user->givePermissionTo($this->readPermission);
        $email_templates = create_test_email_template(10);
        $this->json(
            'GET',
            '/api/email_templates?api_token='.$this->user->api_token.'&search='.$email_templates[2]->subject
        )->seeStatusCode(200)->seeJson([
            'subject' => $email_templates[2]->subject,
        ]);
    }

    /** @test */
    public function can_show_a_second_results_page()
    {
        $this->user->givePermissionTo($this->readPermission);
        $email_templates = create_test_email_template(50);
        $this->json(
            'GET',
            '/api/email_templates?api_token='.$this->user->api_token.'&page=2'
        )->seeStatusCode(200)->seeJson([
            'current_page' => 2,
        ]);
    }

    /** @test */
    public function fails_if_trying_to_update_nonexisting_email_template()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json(
            'PATCH',
            '/api/email_templates/2?api_token='.$this->user->api_token
        )->seeStatusCode(404)->seeJson([
            'message' => 'Record not found',
        ]);
    }

    /** @test */
    public function fails_if_trying_to_modify_a_email_template_without_payload()
    {
        $this->user->givePermissionTo($this->writePermission);
        $email_template = create_test_email_template();
        $this->json(
            'PATCH',
            '/api/email_templates/'.$email_template->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(422)->seeJson([
            'client_id' => ['The client id field is required.'],
        ]);
    }

    /** @test */
    public function fails_if_trying_to_modify_an_email_template_without_permission()
    {
        $email_template = create_test_email_template();
        $this->json(
            'PATCH',
            '/api/email_templates/'.$email_template->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.',
        ]);
    }

    /** @test */
    public function can_modify_an_email_template()
    {
        $this->user->givePermissionTo($this->writePermission);
        $language = create_test_language();
        $email_template = create_test_email_template();
        $this->json('PATCH', '/api/email_templates/'.$email_template->id.'?api_token='.$this->user->api_token, [
            'client_id' => $this->client->id,
            'language_id' => $language->id,
            'name' => 'Updated-Test',
            'subject' => 'Test',
        ])->seeStatusCode(200)->seeJson([
            'name' => 'Updated-Test',
        ]);
    }

    /** @test */
    public function fails_if_trying_to_delete_a_non_existing_email_template()
    {
        $this->user->givePermissionTo($this->deletePermission);
        $this->json(
            'DELETE',
            '/api/email_templates/1?api_token='.$this->user->api_token
        )->seeStatusCode(404)->seeJson([
            'message' => 'Record not found',
        ]);
    }

    /** @test */
    public function fails_to_delete_an_email_template_without_permission()
    {
        $email_template = create_test_email_template();
        $this->json(
            'DELETE',
            '/api/email_templates/'.$email_template->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.',
        ]);
    }

    /** @test */
    public function can_delete_an_email_template()
    {
        $this->user->givePermissionTo($this->deletePermission);
        $email_template = create_test_email_template();
        $this->json(
            'DELETE',
            '/api/email_templates/'.$email_template->id.'?api_token='.$this->user->api_token
        )->seeStatusCode(200)->seeJson([
            'success' => true,
        ]);
    }
}

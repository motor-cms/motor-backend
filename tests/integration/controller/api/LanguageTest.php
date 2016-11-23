<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LanguageTest extends TestCase
{

    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $deletePermission;

    protected $tables = [ 'users', 'languages', 'permissions', 'user_has_permissions', 'user_has_roles', 'roles' ];


    public function setUp()
    {
        parent::setUp();

        $this->addDefaults();
    }


    protected function addDefaults()
    {
        $this->user   = create_test_user();

        $this->readPermission   = create_test_permission_with_name('languages.read');
        $this->writePermission  = create_test_permission_with_name('languages.write');
        $this->deletePermission = create_test_permission_with_name('languages.delete');
    }


    /**
     * @test
     */
    public function returns_403_if_not_authenticated()
    {
        $this->json('GET', '/api/languages/1')->seeStatusCode(401)->seeJson([ 'error' => 'Unauthenticated.' ]);
    }


    /** @test */
    public function returns_404_for_non_existing_record()
    {
        $this->user->givePermissionTo($this->readPermission);
        $this->json('GET', '/api/languages/1?api_token=' . $this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found',
        ]);
    }


    /** @test */
    public function fails_if_trying_to_create_without_payload()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('POST', '/api/languages?api_token=' . $this->user->api_token)->seeStatusCode(422)->seeJson([
            'english_name' => [ "The english name field is required." ]
        ]);
    }


    /** @test */
    public function fails_if_trying_to_create_without_permission()
    {
        $this->json('POST', '/api/languages?api_token=' . $this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => "Access denied."
        ]);
    }


    /** @test */
    public function can_create_a_new_language()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('POST', '/api/languages?api_token=' . $this->user->api_token, [
            'iso_639_1'    => 'DE',
            'english_name' => 'German',
            'native_name'  => 'Deutsch'
        ])->seeStatusCode(200)->seeJson([
            'english_name' => 'German'
        ]);
    }


    /** @test */
    public function can_show_a_single_language()
    {
        $this->user->givePermissionTo($this->readPermission);
        $language = create_test_language();
        $this->json('GET',
            '/api/languages/' . $language->id . '?api_token=' . $this->user->api_token)->seeStatusCode(200)->seeJson([
            'english_name' => $language->english_name
        ]);
    }


    /** @test */
    public function fails_to_show_a_single_language_without_permission()
    {
        $language = create_test_language();
        $this->json('GET',
            '/api/languages/' . $language->id . '?api_token=' . $this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.'
        ]);
    }


    /** @test */
    public function can_get_empty_result_when_trying_to_show_multiple_languages()
    {
        $this->user->givePermissionTo($this->readPermission);
        $this->json('GET', '/api/languages?api_token=' . $this->user->api_token)->seeStatusCode(200)->seeJson([
            'total' => 0
        ]);
    }


    /** @test */
    public function can_show_multiple_languages()
    {
        $this->user->givePermissionTo($this->readPermission);
        $languages = create_test_language(10);
        $this->json('GET', '/api/languages?api_token=' . $this->user->api_token)->seeStatusCode(200)->seeJson([
            'english_name' => $languages[0]->english_name
        ]);
    }


    /** @test */
    public function can_search_for_a_language()
    {
        $this->user->givePermissionTo($this->readPermission);
        $languages = create_test_language(10);
        $this->json('GET',
            '/api/languages?api_token=' . $this->user->api_token . '&search=' . $languages[2]->iso_639_1)->seeStatusCode(200)->seeJson([
            'iso_639_1' => $languages[2]->iso_639_1
        ]);
    }


    /** @test */
    public function can_show_a_second_results_page()
    {
        $this->user->givePermissionTo($this->readPermission);
        create_test_language(50);
        $this->json('GET',
            '/api/languages?api_token=' . $this->user->api_token . '&page=2')->seeStatusCode(200)->seeJson([
            'current_page' => 2
        ]);
    }


    /** @test */
    public function fails_if_trying_to_update_nonexisting_language()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('PATCH', '/api/languages/2?api_token=' . $this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found'
        ]);
    }


    /** @test */
    public function fails_if_trying_to_modify_a_language_without_payload()
    {
        $this->user->givePermissionTo($this->writePermission);
        $language = create_test_language();
        $this->json('PATCH',
            '/api/languages/' . $language->id . '?api_token=' . $this->user->api_token)->seeStatusCode(422)->seeJson([
            'english_name' => [ 'The english name field is required.' ]
        ]);
    }


    /** @test */
    public function fails_if_trying_to_modify_a_language_without_permission()
    {
        $language = create_test_language();
        $this->json('PATCH',
            '/api/languages/' . $language->id . '?api_token=' . $this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.'
        ]);
    }


    /** @test */
    public function can_modify_a_language()
    {
        $this->user->givePermissionTo($this->writePermission);
        $language = create_test_language();
        $this->json('PATCH', '/api/languages/' . $language->id . '?api_token=' . $this->user->api_token, [
            'iso_639_1'    => $language->iso_639_1,
            'english_name' => $language->english_name,
            'native_name'  => 'Test'
        ])->seeStatusCode(200)->seeJson([
            'native_name' => 'Test'
        ]);
    }


    /** @test */
    public function fails_if_trying_to_delete_a_non_existing_language()
    {
        $this->user->givePermissionTo($this->deletePermission);
        $this->json('DELETE', '/api/languages/1?api_token=' . $this->user->api_token)->seeStatusCode(404)->seeJson([
            'message' => 'Record not found'
        ]);
    }

    /** @test */
    public function fails_to_delete_a_client_without_permission()
    {
        $language = create_test_language();
        $this->json('DELETE',
            '/api/language/' . $language->id . '?api_token=' . $this->user->api_token)->seeStatusCode(403)->seeJson([
            'error' => 'Access denied.'
        ]);
    }

    /** @test */
    public function can_delete_a_language()
    {
        $this->user->givePermissionTo($this->deletePermission);
        $language = create_test_language();
        $this->json('DELETE',
            '/api/languages/' . $language->id . '?api_token=' . $this->user->api_token)->seeStatusCode(200)->seeJson([
            'success' => true
        ]);
    }
}

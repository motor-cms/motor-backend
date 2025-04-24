<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Motor\Backend\Models\User;

/**
 * Class MotorBackendApiProfileTest
 */
class MotorBackendApiProfileTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected $readPermission;

    protected $writePermission;

    protected $tables = [
        'users',
        'roles',
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

        $this->addDefaults();
    }

    protected function addDefaults()
    {
        $this->user = create_test_user();

        $this->readPermission = create_test_permission_with_name('profile.read');
        $this->writePermission = create_test_permission_with_name('profile.write');
    }

    /**
     * @test
     */
    public function returns_403_if_not_authenticated()
    {
        $this->json('GET', '/api/profile/me')->seeStatusCode(401)->seeJson(['error' => 'Unauthenticated.']);
    }

    /** @test */
    public function can_show_own_profile()
    {
        $this->user->givePermissionTo($this->readPermission);
        $this->json('GET', '/api/profile/me?api_token='.$this->user->api_token)->seeStatusCode(200)->seeJson([
            'name' => $this->user->name,
        ]);
    }

    /**
     * @test
     */
    public function returns_403_if_trying_to_update_while_not_authenticated()
    {
        $this->json('PATCH', '/api/profile/edit')->seeStatusCode(401)->seeJson(['error' => 'Unauthenticated.']);
    }

    /** @test */
    public function fails_if_trying_to_modify_profile_without_payload()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('PATCH', '/api/profile/edit?api_token='.$this->user->api_token)->seeStatusCode(422)->seeJson([
            'name' => ['The name field is required.'],
        ]);
    }

    /** @test */
    public function can_modify_profile()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('PATCH', '/api/profile/edit?api_token='.$this->user->api_token, [
            'name' => 'TestRole',
            'email' => $this->user->email,
        ])->seeStatusCode(200)->seeJson([
            'name' => 'TestRole',
            'email' => $this->user->email,
        ]);
    }

    /** @test */
    public function can_modify_profile_and_upload_image()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('PATCH', '/api/profile/edit?api_token='.$this->user->api_token, [
            'name' => 'TestRole',
            'email' => $this->user->email,
            'avatar' => base64_encode(file_get_contents(__DIR__.'/../../../../public/images/motor-logo-large.png')),
        ])->seeStatusCode(200)->seeJson([
            'name' => 'TestRole',
            'email' => $this->user->email,
            'collection' => 'avatar',
        ]);
    }

    // /**
    // * @test
    // */
    // public function can_modify_profile_and_upload_image_and_delete_it_again()
    // {
    //    $this->user->givePermissionTo($this->writePermission);
    //
    //    $this->json('PATCH', '/api/profile/edit?api_token=' . $this->user->api_token, [
    //        'name'   => 'Testname',
    //        'email'  => $this->user->email,
    //        'avatar' => base64_encode(file_get_contents(__DIR__ . '/../../../../public/images/motor-logo-large.png'))
    //    ])->seeStatusCode(200)->seeJson([
    //        'name'       => 'Testname',
    //        'email'      => $this->user->email,
    //        'collection' => 'avatar'
    //    ]);
    //
    //    $this->user = User::find($this->user->id);
    //
    //    $this->json('PATCH', '/api/profile/edit?api_token=' . $this->user->api_token, [
    //        'name'          => 'TestName2',
    //        'email'         => $this->user->email,
    //        'avatar_delete' => 1
    //    ])->seeStatusCode(200)->dontSeeJson([
    //        'collection' => 'avatar',
    //    ]);
    // }

    /** @test */
    public function can_modify_profile_and_upload_image_and_set_custom_filename()
    {
        $this->user->givePermissionTo($this->writePermission);
        $this->json('PATCH', '/api/profile/edit?api_token='.$this->user->api_token, [
            'name' => 'Testname',
            'email' => $this->user->email,
            'avatar' => base64_encode(file_get_contents(__DIR__.'/../../../../public/images/motor-logo-large.png')),
            'avatar_name' => 'custom_filename.png',
        ])->seeStatusCode(200)->seeJson([
            'name' => 'Testname',
            'email' => $this->user->email,
            'collection' => 'avatar',
            'file_name' => 'custom_filename.png',
        ]);
    }
}

<?php

namespace Motor\Backend\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Motor\Backend\Http\Requests\Backend\ProfileEditRequest;
use Motor\Backend\Http\Controllers\ApiController;
use Motor\Backend\Services\ProfileEditService;
use Motor\Backend\Http\Resources\UserResource;

/**
 * Class ProfileEditController
 * @package Motor\Backend\Http\Controllers\Api
 */
class ProfileEditController extends ApiController
{

    /**
     * Update the specified resource in storage.
     *
     * @param \Motor\Backend\Http\Requests\Backend\ProfileEditRequest $request
     * @return \Motor\Backend\Http\Resources\UserResource
     */
    public function update(ProfileEditRequest $request)
    {
        $result   = ProfileEditService::update(Auth::user(), $request)->getResult();
        return (new UserResource($result))->additional(['message' => 'Profile updated']);
    }


    /**
     * @return \Motor\Backend\Http\Resources\UserResource
     */
    public function me()
    {
        $result   = ProfileEditService::show(Auth::user())->getResult();
        return (new UserResource($result))->additional(['message' => 'Profile read']);
    }
}

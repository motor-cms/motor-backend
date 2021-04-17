<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;
use Motor\Backend\Http\Requests\Backend\UserRequest;
use Motor\Backend\Http\Resources\UserCollection;
use Motor\Backend\Http\Resources\UserResource;
use Motor\Backend\Models\User;
use Motor\Backend\Services\UserService;

/**
 * Class UsersController
 * @package Motor\Backend\Http\Controllers\Api
 */
class UsersController extends ApiController
{

    protected string $modelResource = 'user';

    /**
     * Display a listing of the resource.
     *
     * @return UserCollection
     */
    public function index()
    {
        $paginator = UserService::collection()->getPaginator();
        return (new UserCollection($paginator))->additional(['message' => 'User collection read']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $result = UserService::create($request)->getResult();
        return (new UserResource($result))->additional(['message' => 'User created'])->response()->setStatusCode(201);
    }


    /**
     * Display the specified resource.
     *
     * @param User $record
     * @return UserResource
     */
    public function show(User $record)
    {
        $result = UserService::show($record)->getResult();
        return (new UserResource($result))->additional(['message' => 'User read']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $record
     * @return UserResource
     */
    public function update(UserRequest $request, User $record)
    {
        $result = UserService::update($record, $request)->getResult();
        return (new UserResource($result))->additional(['message' => 'User updated']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param User $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $record)
    {
        $result = UserService::delete($record)->getResult();

        if ($result) {
            return response()->json(['message' => 'User deleted']);
        }
        return response()->json(['message' => 'Problem deleting user'], 404);
    }
}

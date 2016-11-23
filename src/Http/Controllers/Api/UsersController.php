<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Http\Requests\Backend\UserRequest;
use Motor\Backend\Models\User;
use Motor\Backend\Services\UserService;
use Motor\Backend\Transformers\UserTransformer;

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = UserService::collection()->getPaginator();
        $resource = $this->transformPaginator($result, UserTransformer::class, 'client,permissions,roles,files');

        return $this->respondWithJson('User collection read', $resource);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $result = UserService::create($request)->getResult();
        $resource = $this->transformItem($result, UserTransformer::class, 'client,permissions,roles,files');

        return $this->respondWithJson('User created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $record)
    {
        $result = UserService::show($record)->getResult();
        $resource = $this->transformItem($result, UserTransformer::class, 'client,permissions,roles,files');

        return $this->respondWithJson('User read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $record)
    {
        $result = UserService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, UserTransformer::class, 'client,permissions,roles,files');

        return $this->respondWithJson('User updated', $resource);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $record)
    {
        $result = UserService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('User deleted', ['success' => true]);
        }
        return $this->respondWithJson('User NOT deleted', ['success' => false]);
    }
}

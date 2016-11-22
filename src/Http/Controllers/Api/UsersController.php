<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Http\Requests\Backend\UserRequest;
use Motor\Backend\Models\User;
use Motor\Backend\Services\UserService;

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

        return response()->json(['data' => $result]);
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

        return response()->json(['data' => $result]);
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

        return response()->json(['data' => $result]);
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

        return response()->json(['data' => $result]);
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

        return response()->json(['data' => $result]);
    }
}

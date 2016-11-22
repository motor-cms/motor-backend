<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Http\Requests\Backend\PermissionRequest;
use Motor\Backend\Models\Permission;
use Motor\Backend\Services\PermissionService;

class PermissionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = PermissionService::collection()->getPaginator();

        return response()->json(['data' => $result]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $result = PermissionService::create($request)->getResult();

        return response()->json(['data' => $result]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $record)
    {
        $result = PermissionService::show($record)->getResult();

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
    public function update(PermissionRequest $request, Permission $record)
    {
        $result = PermissionService::update($record, $request)->getResult();

        return response()->json(['data' => $result]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $record)
    {
        $result = PermissionService::delete($record)->getResult();

        return response()->json(['data' => $result]);
    }
}

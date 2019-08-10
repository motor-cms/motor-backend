<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Http\Requests\Backend\RoleRequest;
use Motor\Backend\Models\Role;
use Motor\Backend\Services\RoleService;
use Motor\Backend\Transformers\RoleTransformer;

/**
 * Class RolesController
 * @package Motor\Backend\Http\Controllers\Api
 */
class RolesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $paginator = RoleService::collection()->getPaginator();
        $resource  = $this->transformPaginator($paginator, RoleTransformer::class, 'permissions');

        return $this->respondWithJson('Role collection read', $resource);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleRequest $request)
    {
        $result   = RoleService::create($request)->getResult();
        $resource = $this->transformItem($result, RoleTransformer::class, 'permissions');

        return $this->respondWithJson('Role created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param Role $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $record)
    {
        $result   = RoleService::show($record)->getResult();
        $resource = $this->transformItem($result, RoleTransformer::class, 'permissions');

        return $this->respondWithJson('Role read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param Role        $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RoleRequest $request, Role $record)
    {
        $result   = RoleService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, RoleTransformer::class, 'permissions');

        return $this->respondWithJson('Role updated', $resource);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Role $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $record)
    {
        $result = RoleService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('Role deleted', [ 'success' => true ]);
        }

        return $this->respondWithJson('Role NOT deleted', [ 'success' => false ]);
    }
}

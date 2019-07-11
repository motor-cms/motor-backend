<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Http\Requests\Backend\PermissionRequest;
use Motor\Backend\Models\Permission;
use Motor\Backend\Services\PermissionService;
use Motor\Backend\Transformers\PermissionTransformer;

/**
 * Class PermissionsController
 * @package Motor\Backend\Http\Controllers\Api
 */
class PermissionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = PermissionService::collection()->getPaginator();
        $resource  = $this->transformPaginator($paginator, PermissionTransformer::class, 'group');

        return $this->respondWithJson('Permission collection read', $resource);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $result   = PermissionService::create($request)->getResult();
        $resource = $this->transformItem($result, PermissionTransformer::class, 'group');

        return $this->respondWithJson('Permission created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $record)
    {
        $result   = PermissionService::show($record)->getResult();
        $resource = $this->transformItem($result, PermissionTransformer::class, 'group');

        return $this->respondWithJson('Permission read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, Permission $record)
    {
        $result   = PermissionService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, PermissionTransformer::class, 'group');

        return $this->respondWithJson('Permission updated', $resource);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $record)
    {
        $result = PermissionService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('Permission deleted', [ 'success' => true ]);
        }

        return $this->respondWithJson('Permission NOT deleted', [ 'success' => false ]);
    }
}

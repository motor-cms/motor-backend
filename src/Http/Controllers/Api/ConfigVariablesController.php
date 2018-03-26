<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;

use Motor\Backend\Models\ConfigVariable;
use Motor\Backend\Http\Requests\Backend\ConfigVariableRequest;
use Motor\Backend\Services\ConfigVariableService;
use Motor\Backend\Transformers\ConfigVariableTransformer;

class ConfigVariablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = ConfigVariableService::collection()->getPaginator();
        $resource = $this->transformPaginator($paginator, ConfigVariableTransformer::class);

        return $this->respondWithJson('ConfigVariable collection read', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ConfigVariableRequest $request)
    {
        $result = ConfigVariableService::create($request)->getResult();
        $resource = $this->transformItem($result, ConfigVariableTransformer::class);

        return $this->respondWithJson('ConfigVariable created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ConfigVariable $record)
    {
        $result = ConfigVariableService::show($record)->getResult();
        $resource = $this->transformItem($result, ConfigVariableTransformer::class);

        return $this->respondWithJson('ConfigVariable read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ConfigVariableRequest $request, ConfigVariable $record)
    {
        $result = ConfigVariableService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, ConfigVariableTransformer::class);

        return $this->respondWithJson('ConfigVariable updated', $resource);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConfigVariable $record)
    {
        $result = ConfigVariableService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('ConfigVariable deleted', ['success' => true]);
        }
        return $this->respondWithJson('ConfigVariable NOT deleted', ['success' => false]);
    }
}
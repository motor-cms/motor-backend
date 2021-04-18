<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;
use Motor\Backend\Http\Requests\Backend\ConfigVariableRequest;
use Motor\Backend\Http\Resources\ConfigVariableCollection;
use Motor\Backend\Http\Resources\ConfigVariableResource;
use Motor\Backend\Models\ConfigVariable;
use Motor\Backend\Services\ConfigVariableService;

/**
 * Class ConfigVariablesController
 *
 * @package Motor\Backend\Http\Controllers\Api
 */
class ConfigVariablesController extends ApiController
{
    protected string $modelResource = 'config_variable';

    /**
     * Display a listing of the resource.
     *
     * @return \Motor\Backend\Http\Resources\ConfigVariableCollection
     */
    public function index()
    {
        $paginator = ConfigVariableService::collection()
                                          ->getPaginator();

        return (new ConfigVariableCollection($paginator))->additional(['message' => 'Config variable collection read']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Motor\Backend\Http\Requests\Backend\ConfigVariableRequest $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(ConfigVariableRequest $request)
    {
        $result = ConfigVariableService::create($request)
                                       ->getResult();

        return (new ConfigVariableResource($result))->additional(['message' => 'Config variable created'])
                                                    ->response()
                                                    ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param \Motor\Backend\Models\ConfigVariable $record
     * @return \Motor\Backend\Http\Resources\ConfigVariableResource
     */
    public function show(ConfigVariable $record)
    {
        $result = ConfigVariableService::show($record)
                                       ->getResult();

        return (new ConfigVariableResource($result))->additional(['message' => 'Config variable read']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Motor\Backend\Http\Requests\Backend\ConfigVariableRequest $request
     * @param \Motor\Backend\Models\ConfigVariable $record
     * @return \Motor\Backend\Http\Resources\ConfigVariableResource
     */
    public function update(ConfigVariableRequest $request, ConfigVariable $record)
    {
        $result = ConfigVariableService::update($record, $request)
                                       ->getResult();

        return (new ConfigVariableResource($result))->additional(['message' => 'Config variable updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Motor\Backend\Models\ConfigVariable $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ConfigVariable $record)
    {
        $result = ConfigVariableService::delete($record)
                                       ->getResult();

        if ($result) {
            return response()->json(['message' => 'Config variable deleted']);
        }

        return response()->json(['message' => 'Problem deleting config variable'], 400);
    }
}

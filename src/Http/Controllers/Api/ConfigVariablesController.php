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
    protected string $model = 'Motor\Backend\Models\ConfigVariable';

    protected string $modelResource = 'config_variable';

    /**
     * @OA\Get (
     *   tags={"ConfigVariablesController"},
     *   path="/api/config_variables",
     *   summary="Get config variables collection",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/ConfigVariableResource")
     *       ),
     *       @OA\Property(
     *         property="meta",
     *         ref="#/components/schemas/PaginationMeta"
     *       ),
     *       @OA\Property(
     *         property="links",
     *         ref="#/components/schemas/PaginationLinks"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Collection read"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   )
     * )
     *
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
     * @OA\Post (
     *   tags={"ConfigVariablesController"},
     *   path="/api/config_variables",
     *   summary="Create new config variable",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/ConfigVariableRequest")
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/ConfigVariableResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Config variable created"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
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
     * @OA\Get (
     *   tags={"ConfigVariablesController"},
     *   path="/api/config_variables/{config_variable}",
     *   summary="Get single config variable",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="config_variable",
     *     parameter="config_variable",
     *     description="Config variable id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/ConfigVariableResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Config variable read"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
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
     * @OA\Put (
     *   tags={"ConfigVariablesController"},
     *   path="/api/config_variables/{config_variable}",
     *   summary="Update an existing config variable",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/ConfigVariableRequest")
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="config_variable",
     *     parameter="config_variable",
     *     description="Config variable id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/ConfigVariableResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Config variable updated"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
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
     * @OA\Delete (
     *   tags={"ConfigVariablesController"},
     *   path="/api/config_variables/{config_variable}",
     *   summary="Delete a config variable",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="config_variable",
     *     parameter="config_variable",
     *     description="Config variable id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Config variable deleted"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   ),
     *   @OA\Response(
     *     response="400",
     *     description="Bad request",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Problem deleting config variable"
     *       )
     *     )
     *   )
     * )
     *
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

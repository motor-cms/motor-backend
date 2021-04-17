<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;
use Motor\Backend\Http\Requests\Backend\ClientRequest;
use Motor\Backend\Http\Resources\ClientCollection;
use Motor\Backend\Http\Resources\ClientResource;
use Motor\Backend\Models\Client;
use Motor\Backend\Services\ClientService;

/**
 * Class ClientsController
 * @package Motor\Backend\Http\Controllers\Api
 */
class ClientsController extends ApiController
{

    protected string $modelResource = 'client';

    /**
     * Display a listing of the resource.
     *
     * @return ClientCollection
     */
    public function index()
    {
        $paginator = ClientService::collection()->getPaginator();
        return (new ClientCollection($paginator))->additional(['message' => 'Client collection read']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param ClientRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ClientRequest $request)
    {
        $result = ClientService::create($request)->getResult();
        return (new ClientResource($result))->additional(['message' => 'Client created'])->response()->setStatusCode(201);
    }


    /**
     * Display the specified resource.
     *
     * @param Client $record
     * @return ClientResource
     */
    public function show(Client $record)
    {
        $result = ClientService::show($record)->getResult();
        return (new ClientResource($result))->additional(['message' => 'Client read']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param ClientRequest $request
     * @param Client $record
     * @return ClientResource
     */
    public function update(ClientRequest $request, Client $record)
    {
        $result = ClientService::update($record, $request)->getResult();
        return (new ClientResource($result))->additional(['message' => 'Client updated']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Client $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Client $record)
    {
        $result = ClientService::delete($record)->getResult();

        if ($result) {
            return response()->json(['message' => 'Client deleted']);
        }
        return response()->json(['message' => 'Problem deleting Client'], 404);
    }
}

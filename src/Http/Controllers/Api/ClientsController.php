<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Http\Requests\Backend\ClientRequest;
use Motor\Backend\Models\Client;
use Motor\Backend\Services\ClientService;
use Motor\Backend\Transformers\ClientTransformer;

/**
 * Class ClientsController
 * @package Motor\Backend\Http\Controllers\Api
 */
class ClientsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $paginator = ClientService::collection()->getPaginator();
        $resource  = $this->transformPaginator($paginator, ClientTransformer::class);

        return $this->respondWithJson('Client collection read', $resource);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param ClientRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ClientRequest $request)
    {
        $result   = ClientService::create($request)->getResult();
        $resource = $this->transformItem($result, ClientTransformer::class);

        return $this->respondWithJson('Client created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param Client $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Client $record)
    {
        $result   = ClientService::show($record)->getResult();
        $resource = $this->transformItem($result, ClientTransformer::class);

        return $this->respondWithJson('Client read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param ClientRequest $request
     * @param Client        $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ClientRequest $request, Client $record)
    {
        $result   = ClientService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, ClientTransformer::class);

        return $this->respondWithJson('Client updated', $resource);
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
            return $this->respondWithJson('Client deleted', [ 'success' => true ]);
        }

        return $this->respondWithJson('Client NOT deleted', [ 'success' => false ]);
    }
}

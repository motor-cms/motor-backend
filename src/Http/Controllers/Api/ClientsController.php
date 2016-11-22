<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Http\Requests\Backend\ClientRequest;
use Motor\Backend\Models\Client;
use Motor\Backend\Services\ClientService;

class ClientsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = ClientService::collection()->getPaginator();

        return response()->json(['data' => $result]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $result = ClientService::create($request)->getResult();

        return response()->json(['data' => $result]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Client $record)
    {
        $result = ClientService::show($record)->getResult();

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
    public function update(ClientRequest $request, Client $record)
    {
        $result = ClientService::update($record, $request)->getResult();

        return response()->json(['data' => $result]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $record)
    {
        $result = ClientService::delete($record)->getResult();

        return response()->json(['data' => $result]);
    }
}

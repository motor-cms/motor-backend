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
        $result = (new ClientService('ClientApi'))->getPaginator();

        return response($result);
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
        $result = (new ClientService())->store($request->all());

        return response($result);
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
        $result = (new ClientService())->show($record);

        return response($result);
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
        $result = (new ClientService())->update($record, $request->all());

        return response($result);
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
        $result = (new ClientService())->destroy($record);

        return response((string) $result);
    }
}

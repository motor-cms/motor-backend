<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Http\Requests\Backend\EmailTemplateRequest;
use Motor\Backend\Models\EmailTemplate;
use Motor\Backend\Services\EmailTemplateService;

class EmailTemplatesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = EmailTemplateService::collection()->getPaginator();

        return response()->json(['data' => $result]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(EmailTemplateRequest $request)
    {
        $result = EmailTemplateService::create($request)->getResult();

        return response()->json(['data' => $result]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(EmailTemplate $record)
    {
        $result = EmailTemplateService::show($record)->getResult();

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
    public function update(EmailTemplateRequest $request, EmailTemplate $record)
    {
        $result = EmailTemplateService::update($record, $request)->getResult();

        return response()->json(['data' => $result]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailTemplate $record)
    {
        $result = EmailTemplateService::delete($record)->getResult();

        return response()->json(['data' => $result]);
    }
}

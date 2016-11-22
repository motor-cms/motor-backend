<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Http\Requests\Backend\LanguageRequest;
use Motor\Backend\Models\Language;
use Motor\Backend\Services\LanguageService;

class LanguagesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = LanguageService::collection()->getPaginator();

        return response()->json(['data' => $result]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(LanguageRequest $request)
    {
        $result = LanguageService::create($request)->getResult();

        return response()->json(['data' => $result]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Language $record)
    {
        $result = LanguageService::show($record)->getResult();

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
    public function update(LanguageRequest $request, Language $record)
    {
        $result = LanguageService::update($record, $request)->getResult();

        return response()->json(['data' => $result]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $record)
    {
        $result = LanguageService::delete($record)->getResult();

        return response()->json(['data' => $result]);
    }
}

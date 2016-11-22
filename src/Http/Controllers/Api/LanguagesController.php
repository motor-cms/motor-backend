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
        $result = (new LanguageService('LanguageApi'))->getPaginator();

        return response($result);
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
        $result = (new LanguageService())->store($request->all());

        return response($result);
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
        $result = (new LanguageService())->show($record);

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
    public function update(LanguageRequest $request, Language $record)
    {
        $result = (new LanguageService())->update($record, $request->all());

        return response($result);
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
        $result = (new LanguageService())->destroy($record);

        return response((string) $result);
    }
}

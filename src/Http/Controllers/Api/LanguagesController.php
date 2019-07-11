<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Http\Requests\Backend\LanguageRequest;
use Motor\Backend\Models\Language;
use Motor\Backend\Services\LanguageService;
use Motor\Backend\Transformers\LanguageTransformer;

/**
 * Class LanguagesController
 * @package Motor\Backend\Http\Controllers\Api
 */
class LanguagesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = LanguageService::collection()->getPaginator();
        $resource  = $this->transformPaginator($paginator, LanguageTransformer::class);

        return $this->respondWithJson('Language collection read', $resource);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(LanguageRequest $request)
    {
        $result   = LanguageService::create($request)->getResult();
        $resource = $this->transformItem($result, LanguageTransformer::class);

        return $this->respondWithJson('Language created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Language $record)
    {
        $result   = LanguageService::show($record)->getResult();
        $resource = $this->transformItem($result, LanguageTransformer::class);

        return $this->respondWithJson('Language read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(LanguageRequest $request, Language $record)
    {
        $result   = LanguageService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, LanguageTransformer::class);

        return $this->respondWithJson('Language updated', $resource);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $record)
    {
        $result = LanguageService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('Language deleted', [ 'success' => true ]);
        }

        return $this->respondWithJson('Language NOT deleted', [ 'success' => false ]);
    }
}

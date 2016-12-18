<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;

use Motor\Backend\Models\CategoryTree;
use Motor\Backend\Http\Requests\Backend\CategoryTreeRequest;
use Motor\Backend\Services\CategoryTreeService;
use Motor\Backend\Transformers\CategoryTreeTransformer;

class CategoryTreesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = CategoryTreeService::collection()->getPaginator();
        $resource = $this->transformPaginator($paginator, CategoryTreeTransformer::class);

        return $this->respondWithJson('CategoryTree collection read', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryTreeRequest $request)
    {
        $result = CategoryTreeService::create($request)->getResult();
        $resource = $this->transformItem($result, CategoryTreeTransformer::class);

        return $this->respondWithJson('CategoryTree created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryTree $record)
    {
        $result = CategoryTreeService::show($record)->getResult();
        $resource = $this->transformItem($result, CategoryTreeTransformer::class);

        return $this->respondWithJson('CategoryTree read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryTreeRequest $request, CategoryTree $record)
    {
        $result = CategoryTreeService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, CategoryTreeTransformer::class);

        return $this->respondWithJson('CategoryTree updated', $resource);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryTree $record)
    {
        $result = CategoryTreeService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('CategoryTree deleted', ['success' => true]);
        }
        return $this->respondWithJson('CategoryTree NOT deleted', ['success' => false]);
    }
}
<?php

namespace Motor\Backend\Http\Controllers\Api;

use Illuminate\Http\Request;
use Motor\Backend\Http\Controllers\Controller;

use Motor\Backend\Models\Category;
use Motor\Backend\Http\Requests\Backend\CategoryRequest;
use Motor\Backend\Services\CategoryService;
use Motor\Backend\Transformers\CategoryTransformer;
use Motor\Core\Filter\Renderers\WhereRenderer;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $service = CategoryService::collection();


        $filter = $service->getFilter();
        $filter->add(new WhereRenderer('scope'))->setValue($request->get('scope'));
        $filter->add(new WhereRenderer('parent_id'))->setOperator('!=')->setAllowNull(true)->setValue(null);

        $paginator    = $service->getPaginator();

        $resource = $this->transformPaginator($paginator, CategoryTransformer::class);

        return $this->respondWithJson('Category collection read', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $result = CategoryService::create($request)->getResult();
        $resource = $this->transformItem($result, CategoryTransformer::class);

        return $this->respondWithJson('Category created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Category $record)
    {
        $result = CategoryService::show($record)->getResult();
        $resource = $this->transformItem($result, CategoryTransformer::class);

        return $this->respondWithJson('Category read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $record)
    {
        $result = CategoryService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, CategoryTransformer::class);

        return $this->respondWithJson('Category updated', $resource);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $record)
    {
        $result = CategoryService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('Category deleted', ['success' => true]);
        }
        return $this->respondWithJson('Category NOT deleted', ['success' => false]);
    }
}
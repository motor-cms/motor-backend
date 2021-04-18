<?php

namespace Motor\Backend\Http\Controllers\Api;

use Illuminate\Http\Request;
use Motor\Backend\Http\Controllers\ApiController;
use Motor\Backend\Http\Requests\Backend\CategoryRequest;
use Motor\Backend\Http\Resources\CategoryCollection;
use Motor\Backend\Http\Resources\CategoryResource;
use Motor\Backend\Models\Category;
use Motor\Backend\Services\CategoryService;
use Motor\Core\Filter\Renderers\WhereRenderer;

/**
 * Class CategoriesController
 *
 * @package Motor\Backend\Http\Controllers\Api
 */
class CategoriesController extends ApiController
{
    protected string $modelResource = 'category';

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Motor\Backend\Http\Resources\CategoryCollection
     */
    public function index(Request $request)
    {
        $service = CategoryService::collection();

        $filter = $service->getFilter();
        $filter->add(new WhereRenderer('scope'))
               ->setValue($request->get('scope'));
        $filter->add(new WhereRenderer('parent_id'))
               ->setOperator('!=')
               ->setAllowNull(true)
               ->setValue(null);

        $paginator = $service->getPaginator();

        return (new CategoryCollection($paginator))->additional(['message' => 'Category collection read']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Motor\Backend\Http\Requests\Backend\CategoryRequest $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(CategoryRequest $request)
    {
        $result = CategoryService::create($request)
                                 ->getResult();

        return (new CategoryResource($result))->additional(['message' => 'Category created'])
                                              ->response()
                                              ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param \Motor\Backend\Models\Category $record
     * @return \Motor\Backend\Http\Resources\CategoryResource
     */
    public function show(Category $record)
    {
        $result = CategoryService::show($record)
                                 ->getResult();

        return (new CategoryResource($result))->additional(['message' => 'Category read']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Motor\Backend\Http\Requests\Backend\CategoryRequest $request
     * @param \Motor\Backend\Models\Category $record
     * @return \Motor\Backend\Http\Resources\CategoryResource
     */
    public function update(CategoryRequest $request, Category $record)
    {
        $result = CategoryService::update($record, $request)
                                 ->getResult();

        return (new CategoryResource($result))->additional(['message' => 'Category updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Motor\Backend\Models\Category $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $record)
    {
        $result = CategoryService::delete($record)
                                 ->getResult();

        if ($result) {
            return response()->json(['message' => 'Category deleted']);
        }

        return response()->json(['message' => 'Problem deleting category'], 400);
    }
}

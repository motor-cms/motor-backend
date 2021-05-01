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
    protected string $model = 'Motor\Backend\Models\Category';

    protected string $modelResource = 'category';

    /**
     * @OA\Get (
     *   tags={"CategoriesController"},
     *   path="/api/category_trees/{category_tree}/categories",
     *   summary="Get categories collection",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="category_tree",
     *     parameter="category_tree",
     *     description="Category tree id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/CategoryResource")
     *       ),
     *       @OA\Property(
     *         property="meta",
     *         ref="#/components/schemas/PaginationMeta"
     *       ),
     *       @OA\Property(
     *         property="links",
     *         ref="#/components/schemas/PaginationLinks"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Collection read"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Category tree not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
     * Display a listing of the resource.
     *
     * @param \Motor\Backend\Models\Category $categoryTree
     * @return \Illuminate\Http\JsonResponse|\Motor\Backend\Http\Resources\CategoryCollection
     */
    public function index(Category $categoryTree, Request $request)
    {
        $service = CategoryService::collection();

        if (! is_null($categoryTree->parent_id)) {
            return response()->json(['message' => 'Category tree not found'], 404);
        }

        if (is_null($categoryTree->id)) {
            $scope = $request->get('scope');
        } else {
            $scope = $categoryTree->scope;
        }

        $filter = $service->getFilter();
        $filter->add(new WhereRenderer('scope'))
               ->setValue($scope);
        $filter->add(new WhereRenderer('parent_id'))
               ->setOperator('!=')
               ->setAllowNull(true)
               ->setValue(null);

        $paginator = $service->getPaginator();

        return (new CategoryCollection($paginator))->additional(['message' => 'Category collection read']);
    }

    /**
     * @OA\Post (
     *   tags={"CategoriesController"},
     *   path="/api/category_trees/{category_tree}/categories",
     *   summary="Create new category",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="category_tree",
     *     parameter="category_tree",
     *     description="Category tree id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/CategoryResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Category created"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
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
     * @OA\Get (
     *   tags={"CategoriesController"},
     *   path="/api/category_trees/{category_tree}/categories/{category}",
     *   summary="Get single category",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="category_tree",
     *     parameter="category_tree",
     *     description="Category tree id"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="category",
     *     parameter="category",
     *     description="Category id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/CategoryResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Category tree read"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
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
     * @OA\Put (
     *   tags={"CategoriesController"},
     *   path="/api/category_trees/{category_tree}/categories/{category}",
     *   summary="Update an existing category",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="category_tree",
     *     parameter="category_tree",
     *     description="Category tree id"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="category",
     *     parameter="category",
     *     description="Category id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/CategoryResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Category updated"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   )
     * )
     *
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
     * @OA\Delete (
     *   tags={"CategoriesController"},
     *   path="/api/category_trees/{category_tree}/categories/{category}",
     *   summary="Delete a category",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="category_tree",
     *     parameter="category_tree",
     *     description="Category tree id"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="integer"),
     *     in="path",
     *     name="category",
     *     parameter="category",
     *     description="Category id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Category deleted"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found",
     *     @OA\JsonContent(ref="#/components/schemas/NotFound"),
     *   ),
     *   @OA\Response(
     *     response="400",
     *     description="Bad request",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Problem deleting category"
     *       )
     *     )
     *   )
     * )
     *
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

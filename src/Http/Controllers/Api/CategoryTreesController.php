<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;
use Motor\Backend\Http\Requests\Backend\CategoryTreeRequest;
use Motor\Backend\Http\Resources\CategoryCollection;
use Motor\Backend\Http\Resources\CategoryTreeResource;
use Motor\Backend\Models\Category;
use Motor\Backend\Services\CategoryService;
use Motor\Core\Filter\Renderers\WhereRenderer;

/**
 * Class CategoriesController
 *
 * @package Motor\Backend\Http\Controllers\Api
 */
class CategoryTreesController extends ApiController
{
    protected string $model = 'Motor\Backend\Models\Category';

    protected string $modelResource = 'category';

    /**
     * @OA\Get (
     *   tags={"CategoryTreesController"},
     *   path="/api/category_trees",
     *   summary="Get category tree collection",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/CategoryTreeResource")
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
     *   )
     * )
     *
     * Display a listing of the resource.
     *
     * @return \Motor\Backend\Http\Resources\CategoryCollection
     */
    public function index()
    {
        $service = CategoryService::collection();

        $filter = $service->getFilter();
        $filter->add(new WhereRenderer('parent_id'))
               ->setDefaultValue(null)
               ->setAllowNull(true);

        $paginator = $service->getPaginator();

        return (new CategoryCollection($paginator))->additional(['message' => 'Category tree collection read']);
    }

    /**
     * @OA\Post (
     *   tags={"CategoryTreesController"},
     *   path="/api/category_trees",
     *   summary="Create new category tree",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/CategoryTreeRequest")
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/CategoryTreeResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Category tree created"
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
     * @param \Motor\Backend\Http\Requests\Backend\CategoryTreeRequest $request
     * @return mixed
     */
    public function store(CategoryTreeRequest $request)
    {
        $result = CategoryService::create($request)
                                 ->getResult();

        return (new CategoryTreeResource($result))->additional(['message' => 'Category tree created'])
                                                  ->response()
                                                  ->setStatusCode(201);
    }

    /**
     * @OA\Get (
     *   tags={"CategoryTreesController"},
     *   path="/api/category_trees/{category}",
     *   summary="Get single category tree",
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
     *     name="category",
     *     parameter="category",
     *     description="Category tree id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/CategoryTreeResource"
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
     * @return \Motor\Backend\Http\Resources\CategoryTreeResource
     */
    public function show(Category $record)
    {
        $result = CategoryService::show($record)
                                 ->getResult();

        return (new CategoryTreeResource($result->load('children')))->additional(['message' => 'Category tree read']);
    }

    /**
     * @OA\Put (
     *   tags={"CategoryTreesController"},
     *   path="/api/category_trees/{category}",
     *   summary="Update an existing category tree",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/CategoryTreeRequest")
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
     *     name="category",
     *     parameter="category",
     *     description="Category tree id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/CategoryTreeResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Category tree updated"
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
     * @param \Motor\Backend\Http\Requests\Backend\CategoryTreeRequest $request
     * @param \Motor\Backend\Models\Category $record
     * @return \Motor\Backend\Resources\Http\Resources\CategoryTreeResource
     */
    public function update(CategoryTreeRequest $request, Category $record)
    {
        $result = CategoryService::update($record, $request)
                                 ->getResult();

        return (new CategoryTreeResource($result))->additional(['message' => 'Category tree updated']);
    }

    /**
     * @OA\Delete (
     *   tags={"CategoryTreesController"},
     *   path="/api/category_trees/{category}",
     *   summary="Delete a category tree",
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
     *     name="category",
     *     parameter="category",
     *     description="Category tree id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Category tree deleted"
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
     *         example="Problem deleting category tree"
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
            return response()->json(['message' => 'Category tree deleted']);
        }

        return response()->json(['message' => 'Problem deleting category tree'], 400);
    }
}

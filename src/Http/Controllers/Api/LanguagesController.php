<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;
use Motor\Backend\Http\Requests\Backend\LanguageRequest;
use Motor\Backend\Http\Resources\LanguageCollection;
use Motor\Backend\Http\Resources\LanguageResource;
use Motor\Backend\Models\Language;
use Motor\Backend\Services\LanguageService;

/**
 * Class LanguagesController
 *
 * @package Motor\Backend\Http\Controllers\Api
 */
class LanguagesController extends ApiController
{
    protected string $model = 'Motor\Backend\Models\Language';
    protected string $modelResource = 'language';

    /**
     * @OA\Get (
     *   tags={"LanguagesController"},
     *   path="/api/languages",
     *   summary="Get language collection",
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
     *         @OA\Items(ref="#/components/schemas/LanguageResource")
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
     * @return \Motor\Backend\Http\Resources\LanguageCollection
     */
    public function index()
    {
        $paginator = LanguageService::collection()
                                    ->getPaginator();

        return (new LanguageCollection($paginator))->additional(['message' => 'Language collection read']);
    }

    /**
     * @OA\Post (
     *   tags={"LanguagesController"},
     *   path="/api/languages",
     *   summary="Create new language",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/LanguageRequest")
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
     *         ref="#/components/schemas/LanguageResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Language created"
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
     * @param \Motor\Backend\Http\Requests\Backend\LanguageRequest $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(LanguageRequest $request)
    {
        $result = LanguageService::create($request)
                                 ->getResult();

        return (new LanguageResource($result))->additional(['message' => 'Language created'])
                                              ->response()
                                              ->setStatusCode(201);
    }

    /**
     * @OA\Get (
     *   tags={"LanguagesController"},
     *   path="/api/languages/{language}",
     *   summary="Get single language",
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
     *     name="language",
     *     parameter="language",
     *     description="Language id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/LanguageResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Language read"
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
     * @param \Motor\Backend\Models\Language $record
     * @return \Motor\Backend\Http\Resources\LanguageResource
     */
    public function show(Language $record)
    {
        $result = LanguageService::show($record)
                                 ->getResult();

        return (new LanguageResource($result))->additional(['message' => 'Language read']);
    }

    /**
     * @OA\Put (
     *   tags={"LanguagesController"},
     *   path="/api/languages/{language}",
     *   summary="Update an existing language",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/LanguageRequest")
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
     *     name="language",
     *     parameter="language",
     *     description="Language id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/LanguageResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Language updated"
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
     * @param \Motor\Backend\Http\Requests\Backend\LanguageRequest $request
     * @param \Motor\Backend\Models\Language $record
     * @return \Motor\Backend\Http\Resources\LanguageResource
     */
    public function update(LanguageRequest $request, Language $record)
    {
        $result = LanguageService::update($record, $request)
                                 ->getResult();

        return (new LanguageResource($result))->additional(['message' => 'Language updated']);
    }

    /**
     * @OA\Delete (
     *   tags={"LanguagesController"},
     *   path="/api/languages/{language}",
     *   summary="Delete a language",
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
     *     name="language",
     *     parameter="language",
     *     description="Language id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="Language deleted"
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
     *         example="Problem deleting language"
     *       )
     *     )
     *   )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param \Motor\Backend\Models\Language $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Language $record)
    {
        $result = LanguageService::delete($record)
                                 ->getResult();

        if ($result) {
            return response()->json(['message' => 'Language deleted']);
        }

        return response()->json(['message' => 'Problem deleting language'], 400);
    }
}

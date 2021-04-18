<?php

namespace Motor\Backend\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\ApiController;
use Motor\Backend\Http\Requests\Backend\UserRequest;
use Motor\Backend\Http\Resources\UserCollection;
use Motor\Backend\Http\Resources\UserResource;
use Motor\Backend\Models\User;
use Motor\Backend\Services\UserService;

/**
 * Class UsersController
 *
 * @package Motor\Backend\Http\Controllers\Api
 */
class UsersController extends ApiController
{
    protected string $modelResource = 'user';

    /**
     * @OA\Get (
     *   tags={"UsersController"},
     *   path="/api/users",
     *   summary="Get user collection",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Parameter(
     *       @OA\Schema(type="string"),
     *       in="query",
     *       allowReserved=true,
     *       name="api_token",
     *       parameter="api_token",
     *       description="Personal api_token of the user"
     *     ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *      @OA\JsonContent(
     *        @OA\Property(
     *          property="data",
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/UserResource")
     *        ),
     *        @OA\Property(
     *          property="meta",
     *          ref="#/components/schemas/PaginationMeta"
     *        ),
     *        @OA\Property(
     *          property="links",
     *          ref="#/components/schemas/PaginationLinks"
     *        ),
     *        @OA\Property(
     *          property="message",
     *          type="string",
     *          example="Collection read"
     *        )
     *      )
     *   ),
     *   @OA\Response(
     *     response="403",
     *     description="Access denied",
     *     @OA\JsonContent(ref="#/components/schemas/AccessDenied"),
     *   ),
     * )
     *
     * Display a listing of the resource.
     *
     * @return UserCollection
     */
    public function index()
    {
        $paginator = UserService::collection()
                                ->getPaginator();

        return (new UserCollection($paginator))->additional(['message' => 'User collection read']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $result = UserService::create($request)
                             ->getResult();

        return (new UserResource($result))->additional(['message' => 'User created'])
                                          ->response()
                                          ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param User $record
     * @return UserResource
     */
    public function show(User $record)
    {
        $result = UserService::show($record)
                             ->getResult();

        return (new UserResource($result))->additional(['message' => 'User read']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $record
     * @return UserResource
     */
    public function update(UserRequest $request, User $record)
    {
        $result = UserService::update($record, $request)
                             ->getResult();

        return (new UserResource($result))->additional(['message' => 'User updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $record)
    {
        $result = UserService::delete($record)
                             ->getResult();

        if ($result) {
            return response()->json(['message' => 'User deleted']);
        }

        return response()->json(['message' => 'Problem deleting user'], 404);
    }
}

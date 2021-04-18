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
     *         @OA\Items(ref="#/components/schemas/UserResource")
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
     * @return \Motor\Backend\Http\Resources\UserCollection
     */
    public function index()
    {
        $paginator = UserService::collection()
                                ->getPaginator();

        return (new UserCollection($paginator))->additional(['message' => 'User collection read']);
    }

    /**
     * @OA\Post (
     *   tags={"UsersController"},
     *   path="/api/users",
     *   summary="Create new user",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/UserRequest")
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
     *         ref="#/components/schemas/UserResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="User created"
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
     * @param \Motor\Backend\Http\Requests\Backend\UserRequest $request
     * @return \Illuminate\Http\JsonResponse|object
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
     * @OA\Get (
     *   tags={"UsersController"},
     *   path="/api/users/{user}",
     *   summary="Get single user",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="path",
     *     name="user",
     *     parameter="user",
     *     description="User id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/UserResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="User read"
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
     * @param \Motor\Backend\Models\User $record
     * @return \Motor\Backend\Http\Resources\UserResource
     */
    public function show(User $record)
    {
        $result = UserService::show($record)
                             ->getResult();

        return (new UserResource($result))->additional(['message' => 'User read']);
    }

    /**
     * @OA\Put (
     *   tags={"UsersController"},
     *   path="/api/users/{user}",
     *   summary="Update an existing user",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/UserRequest")
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
     *     @OA\Schema(type="string"),
     *     in="path",
     *     name="user",
     *     parameter="user",
     *     description="User id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="data",
     *         type="object",
     *         ref="#/components/schemas/UserResource"
     *       ),
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="User updated"
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
     * @param \Motor\Backend\Http\Requests\Backend\UserRequest $request
     * @param \Motor\Backend\Models\User $record
     * @return \Motor\Backend\Http\Resources\UserResource
     */
    public function update(UserRequest $request, User $record)
    {
        $result = UserService::update($record, $request)
                             ->getResult();

        return (new UserResource($result))->additional(['message' => 'User updated']);
    }

    /**
     * @OA\Delete (
     *   tags={"UsersController"},
     *   path="/api/users/{user}",
     *   summary="Delete a user",
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="query",
     *     allowReserved=true,
     *     name="api_token",
     *     parameter="api_token",
     *     description="Personal api_token of the user"
     *   ),
     *   @OA\Parameter(
     *     @OA\Schema(type="string"),
     *     in="path",
     *     name="user",
     *     parameter="user",
     *     description="User id"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         example="User deleted"
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
     *         example="Problem deleting user"
     *       )
     *     )
     *   )
     * )
     *
     * Remove the specified resource from storage.
     *
     * @param \Motor\Backend\Models\User $record
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $record)
    {
        $result = UserService::delete($record)
                             ->getResult();

        if ($result) {
            return response()->json(['message' => 'User deleted']);
        }

        return response()->json(['message' => 'Problem deleting user'], 400);
    }
}

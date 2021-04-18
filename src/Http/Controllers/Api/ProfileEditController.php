<?php

namespace Motor\Backend\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Motor\Backend\Http\Controllers\ApiController;
use Motor\Backend\Http\Requests\Backend\ProfileEditRequest;
use Motor\Backend\Http\Resources\UserResource;
use Motor\Backend\Services\ProfileEditService;

/**
 * Class ProfileEditController
 *
 * @package Motor\Backend\Http\Controllers\Api
 */
class ProfileEditController extends ApiController
{
    /**
     * @OA\Put (
     *   tags={"UserProfileController"},
     *   path="/api/profile",
     *   parameters={"Accept": "application/json"},
     *   summary="Update an existing user",
     *   @OA\MediaType(
     *     mediaType="application/json",
     *   ),
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/UserRequest"),
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
     *         example="User profile updated"
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
     * @param \Motor\Backend\Http\Requests\Backend\ProfileEditRequest $request
     * @return \Motor\Backend\Http\Resources\UserResource
     */
    public function update(ProfileEditRequest $request)
    {
        $result = ProfileEditService::update(Auth::user(), $request)
                                    ->getResult();

        return (new UserResource($result))->additional(['message' => 'Profile updated']);
    }

    /**
     * @OA\Get (
     *   tags={"UserProfileController"},
     *   path="/api/profile",
     *   summary="Get user profile",
     *   @OA\MediaType(
     *     mediaType="application/json",
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
     *         example="User profile read"
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
     * Get current users profile
     *
     * @return \Motor\Backend\Http\Resources\UserResource
     */
    public function me()
    {
        $result = ProfileEditService::show(Auth::user())
                                    ->getResult();

        return (new UserResource($result))->additional(['message' => 'Profile read']);
    }
}

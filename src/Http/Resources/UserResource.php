<?php

namespace Motor\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *   schema="UserResource",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="client",
 *     type="object",
 *     ref="#/components/schemas/ClientResource"
 *   ),
 *   @OA\Property(
 *     property="roles",
 *     type="array",
 *     @OA\Items(
 *       ref="#/components/schemas/RoleResource"
 *     ),
 *   ),
 *   @OA\Property(
 *     property="permissions",
 *     type="array",
 *     @OA\Items(
 *       ref="#/components/schemas/PermissionResource"
 *     ),
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     example="My beautiful user name"
 *   ),
 *   @OA\Property(
 *     property="email",
 *     type="string",
 *     example="user@domain.com"
 *   ),
 *   @OA\Property(
 *     property="avatar",
 *     type="object",
 *     ref="#/components/schemas/MediaResource"
 *   )
 * )
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => (int) $this->id,
            'client'      => new ClientResource($this->client),
            'roles'       => RoleResource::collection($this->roles),
            'permissions' => PermissionResource::collection($this->permissions),
            'name'        => $this->name,
            'email'       => $this->email,
            'avatar'      => new MediaResource($this->getFirstMedia('avatar')),
        ];
    }
}

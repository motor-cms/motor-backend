<?php

namespace Motor\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *   schema="PermissionGroupResource",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     example="administration"
 *   ),
 *   @OA\Property(
 *     property="sort_position",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="permissions",
 *     type="array",
 *     @OA\Items(
 *       ref="#/components/schemas/PermissionResource"
 *     )
 *   )
 * )
 */
class PermissionGroupResource extends JsonResource
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
            'id'            => (int) $this->id,
            'name'          => $this->name,
            'sort_position' => (int) $this->sort_position,
            'permissions'   => PermissionResource::collection($this->permissions),
        ];
    }
}

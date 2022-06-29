<?php

namespace Motor\Backend\Http\Resources;

/**
 * @OA\Schema(
 *   schema="RoleResource",
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     example="Administrator"
 *   ),
 *   @OA\Property(
 *     property="guard_name",
 *     type="string",
 *     example="web"
 *   )
 * )
 */
class RoleResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'       => $this->name,
            'guard_name' => $this->guard_name,
        ];
    }
}

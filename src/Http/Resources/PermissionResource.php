<?php

namespace Motor\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *   schema="PermissionResource",
 *       @OA\Property(
 *         property="name",
 *         type="string",
 *         example="dashboard.read"
 *       ),
 *       @OA\Property(
 *         property="guard_name",
 *         type="string",
 *         example="web"
 *       )
 *     )
 */

class PermissionResource extends JsonResource
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
            "name" => $this->name,
            "guard_name" => $this->guard_name,
        ];
    }
}

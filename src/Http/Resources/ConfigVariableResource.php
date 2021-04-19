<?php

namespace Motor\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *   schema="ConfigVariableResource",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="package",
 *     type="string",
 *     example="motor-backend"
 *   ),
 *   @OA\Property(
 *     property="group",
 *     type="string",
 *     example="project"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     example="name"
 *   ),
 *   @OA\Property(
 *     property="value",
 *     type="string",
 *     example="My awesome project"
 *   ),
 *   @OA\Property(
 *     property="is_invisible",
 *     type="boolean",
 *     example="false"
 *   )
 * )
 */
class ConfigVariableResource extends JsonResource
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
            'id'           => (int) $this->id,
            'package'      => $this->package,
            'group'        => $this->group,
            'name'         => $this->name,
            'value'        => $this->value,
            'is_invisible' => (bool) $this->is_invisible,
        ];
    }
}

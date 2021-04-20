<?php

namespace Motor\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *   schema="CategoryResource",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     example="My category"
 *   ),
 *   @OA\Property(
 *     property="scope",
 *     type="string",
 *     example="my-category-tree"
 *   ),
 *   @OA\Property(
 *     property="parent_id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="_lft",
 *     type="integer",
 *     example="3"
 *   ),
 *   @OA\Property(
 *     property="_rgt",
 *     type="integer",
 *     example="5"
 *   ),
 * )
 */
class CategoryResource extends JsonResource
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
            'id'        => (int) $this->id,
            'name'      => $this->name,
            'scope'     => $this->scope,
            'parent_id' => (int) $this->parent_id,
            '_lft'      => (int) $this->_lft,
            '_rgt'      => (int) $this->_rgt,
        ];
    }
}

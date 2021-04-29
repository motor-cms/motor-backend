<?php

namespace Motor\Backend\Http\Resources;

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
class CategoryResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if ($request->route()->compiled->getStaticPrefix() === '/api/category_trees') {
            $this->load('children');
        }

        return [
            'id'        => (int) $this->id,
            'name'      => $this->name,
            'scope'     => $this->scope,
            'parent_id' => (int) $this->parent_id,
            '_lft'      => (int) $this->_lft,
            '_rgt'      => (int) $this->_rgt,
            'children'  => CategoryResource::collection($this->whenLoaded('children')),
        ];
    }
}

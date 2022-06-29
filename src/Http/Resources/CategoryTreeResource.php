<?php

namespace Motor\Backend\Http\Resources;

/**
 * @OA\Schema(
 *   schema="CategoryTreeResource",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     example="My category tree"
 *   ),
 *   @OA\Property(
 *     property="scope",
 *     type="string",
 *     example="my-category-tree"
 *   )
 * )
 */
class CategoryTreeResource extends BaseResource
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
            'id'       => (int) $this->id,
            'name'     => $this->name,
            'scope'    => $this->scope,
            'children' => CategoryResource::collection($this->whenLoaded('children')),
        ];
    }
}

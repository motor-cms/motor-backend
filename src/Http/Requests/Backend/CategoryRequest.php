<?php

namespace Motor\Backend\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class CategoryRequest
 *
 * @package Motor\Backend\Http\Requests\Backend
 */
class CategoryRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="CategoryRequest",
     *   @OA\Property(
     *     property="name",
     *     type="string",
     *     example="New category name"
     *   ),
     *   @OA\Property(
     *     property="parent_id",
     *     type="integer",
     *     example="1"
     *   ),
     *   @OA\Property(
     *     property="previous_sibling_id",
     *     type="integer",
     *     example="2"
     *   ),
     *   @OA\Property(
     *     property="next_sibling_id",
     *     type="integer",
     *     example="4"
     *   ),
     *   required={"name", "parent_id"},
     * )
     */

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                => 'required',
            'parent_id'           => 'required',
            'previous_sibling_id' => 'nullable',
            'next_sibling_id'     => 'nullable',
        ];
    }
}

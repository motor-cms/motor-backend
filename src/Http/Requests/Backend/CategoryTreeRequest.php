<?php

namespace Motor\Backend\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class CategoryTreeRequest
 *
 * @package Motor\Backend\Http\Requests\Backend
 */
class CategoryTreeRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="CategoryTreeRequest",
     *   @OA\Property(
     *     property="name",
     *     type="string",
     *     example="New category tree"
     *   ),
     *   @OA\Property(
     *     property="scope",
     *     type="string",
     *     example="new-category-scope"
     *   ),
     *   required={"name", "scope"},
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
            'name'  => 'required',
            'scope' => 'required|unique',
        ];
    }
}

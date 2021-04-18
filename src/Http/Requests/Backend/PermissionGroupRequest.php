<?php

namespace Motor\Backend\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class PermissionRequest
 *
 * @package Motor\Backend\Http\Requests\Backend
 */
class PermissionGroupRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="PermissionGroupRequest",
     *   @OA\Property(
     *     property="name",
     *     type="string",
     *     example="administration"
     *   ),
     *   required={"name"},
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
            'name' => 'required',
        ];
    }
}

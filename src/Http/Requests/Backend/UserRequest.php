<?php

namespace Motor\Backend\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class UserRequest
 *
 * @package Motor\Backend\Http\Requests\Backend
 */
class UserRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="UserRequest",
     *   @OA\Property(
     *     property="client_id",
     *     type="integer",
     *     example="1"
     *   ),
     *   @OA\Property(
     *     property="name",
     *     type="string",
     *     example="My beautiful name"
     *   ),
     *   @OA\Property(
     *     property="email",
     *     type="string",
     *     example="test@domain.com",
     *     description="Must be a unique RFC valid email address"
     *   ),
     *   @OA\Property(
     *     property="password",
     *     type="string",
     *     example="secret password"
     *   ),
     *   @OA\Property(
     *     property="roles",
     *     type="array",
     *     @OA\Items(
     *       ref="#/components/schemas/RoleRequest"
     *     )
     *   ),
     *   @OA\Property(
     *     property="permissions",
     *     type="array",
     *     @OA\Items(
     *       ref="#/components/schemas/PermissionRequest"
     *     )
     *   ),
     *   required={"name", "email", "password"},
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
        if ($this->method() === 'PATCH') {
            return [
                'name'  => 'required',
                'email' => 'required',
            ];
        } else {
            return [
                'name'     => 'required',
                'email'    => 'required|unique:users',
                'password' => 'required',
            ];
        }
    }
}

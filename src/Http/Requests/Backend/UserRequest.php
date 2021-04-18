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
     *     property="name",
     *     type="string"
     *   ),
     *   @OA\Property(
     *     property="email",
     *     type="string",
     *     description="Must be a RFC valid email address"
     *   ),
     *   @OA\Property(
     *     property="password",
     *     type="string"
     *   ),
     *   required={"name", "email", "password"},
     *   example={"name": "Test user", "email": "a@b.de", "password": "secret"}
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

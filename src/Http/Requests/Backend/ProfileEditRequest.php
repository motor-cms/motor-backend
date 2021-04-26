<?php

namespace Motor\Backend\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class ProfileEditRequest
 *
 * @package Motor\Backend\Http\Requests\Backend
 */
class ProfileEditRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="ProfileEditRequest",
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
     *     property="avatar",
     *     type="file",
     *     example="avatar.png"
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
        return [
            'name'     => 'required',
            'email'    => 'email',
            'password' => 'confirmed',
            'avatar'   => 'nullable|image',
        ];
    }
}

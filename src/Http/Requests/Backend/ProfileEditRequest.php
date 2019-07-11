<?php

namespace Motor\Backend\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class ProfileEditRequest
 * @package Motor\Backend\Http\Requests\Backend
 */
class ProfileEditRequest extends Request
{

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
            'password' => 'confirmed',
        ];
    }
}

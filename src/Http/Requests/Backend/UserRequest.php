<?php

namespace Motor\Backend\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

class UserRequest extends Request
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
        if ($this->method() === 'PATCH') {
            return [
                'name'  => 'required',
                'email' => 'required',
            ];
        } else {
            return [
                'name'     => 'required',
                'email'    => 'required|unique:users',
                'password' => 'required'
            ];
        }
    }
}

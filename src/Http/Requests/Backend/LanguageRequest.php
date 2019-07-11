<?php

namespace Motor\Backend\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class LanguageRequest
 * @package Motor\Backend\Http\Requests\Backend
 */
class LanguageRequest extends Request
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
            'iso_639_1'    => 'required',
            'english_name' => 'required',
            'native_name'  => 'required'
        ];
    }
}

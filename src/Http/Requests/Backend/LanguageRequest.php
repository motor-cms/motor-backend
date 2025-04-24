<?php

namespace Motor\Backend\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class LanguageRequest
 */
class LanguageRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="LanguageRequest",
     *
     *   @OA\Property(
     *     property="iso_639_1",
     *     type="string",
     *     example="de"
     *   ),
     *   @OA\Property(
     *     property="english_name",
     *     type="string",
     *     example="German"
     *   ),
     *   @OA\Property(
     *     property="native_name",
     *     type="string",
     *     example="Deutsch"
     *   ),
     *   required={"iso_639_1", "english_name", "native_name"},
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
            'iso_639_1' => 'required',
            'english_name' => 'required',
            'native_name' => 'required',
        ];
    }
}

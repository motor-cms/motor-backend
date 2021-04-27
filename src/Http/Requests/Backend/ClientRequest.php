<?php

namespace Motor\Backend\Http\Requests\Backend;

use Motor\Backend\Http\Requests\Request;

/**
 * Class ClientRequest
 *
 * @package Motor\Backend\Http\Requests\Backend
 */
class ClientRequest extends Request
{
    /**
     * @OA\Schema(
     *   schema="ClientRequest",
     *   @OA\Property(
     *     property="name",
     *     type="string",
     *     example="New client"
     *   ),
     *   @OA\Property(
     *     property="slug",
     *     type="string",
     *     example="new-client"
     *   ),
     *   @OA\Property(
     *     property="address",
     *     type="string",
     *     example="1234 Motor drive"
     *   ),
     *   @OA\Property(
     *     property="zip",
     *     type="string",
     *     example="90210"
     *   ),
     *   @OA\Property(
     *     property="city",
     *     type="string",
     *     example="Hollywood"
     *   ),
     *   @OA\Property(
     *     property="country_iso_3166_1",
     *     type="string",
     *     example="US"
     *   ),
     *   @OA\Property(
     *     property="website",
     *     type="string",
     *     example="https://www.motor-cms.com"
     *   ),
     *   @OA\Property(
     *     property="description",
     *     type="string",
     *     example="A lengthy description of the client"
     *   ),
     *   @OA\Property(
     *     property="is_active",
     *     type="boolean",
     *     example="true"
     *   ),
     *   @OA\Property(
     *     property="contact_name",
     *     type="string",
     *     example="John Doe"
     *   ),
     *   @OA\Property(
     *     property="contact_email",
     *     type="string",
     *     example="john@doe.com"
     *   ),
     *   @OA\Property(
     *     property="contact_phone",
     *     type="string",
     *     example="+1 123 123 123"
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

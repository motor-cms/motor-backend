<?php

namespace Motor\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *   schema="ClientResource",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="1"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     example="My assigned client"
 *   ),
 *   @OA\Property(
 *     property="slug",
 *     type="string",
 *     example="my-assigned-client"
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
 *     type="text",
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
 *   )
 * )
 */
class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                 => (int) $this->id,
            'name'               => $this->name,
            'slug'               => $this->slug,
            'address'            => $this->address,
            'zip'                => $this->zip,
            'city'               => $this->city,
            'country_iso_3166_1' => $this->country_iso_3166_1,
            'website'            => $this->website,
            'contact_name'       => $this->contact_name,
            'contact_phone'      => $this->contact_phone,
            'contact_email'      => $this->contact_email,
            'description'        => $this->description,
            'is_active'          => (bool) $this->is_active,

        ];
    }
}

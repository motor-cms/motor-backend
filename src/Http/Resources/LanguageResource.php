<?php

namespace Motor\Backend\Http\Resources;

/**
 * @OA\Schema(
 *   schema="LanguageResource",
 *   @OA\Property(
 *     property="id",
 *     type="integer",
 *     example="1"
 *   ),
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
 *   )
 * )
 */
class LanguageResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'           => (int) $this->id,
            'iso_639_1'    => $this->iso_639_1,
            'english_name' => $this->english_name,
            'native_name'  => $this->native_name,
        ];
    }
}

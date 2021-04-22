<?php

namespace Motor\Backend\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *   schema="MediaResource",
 *   @OA\Property(
 *     property="collection",
 *     type="string",
 *     example="images"
 *   ),
 *   @OA\Property(
 *     property="name",
 *     type="string",
 *     example="my-image"
 *   ),
 *   @OA\Property(
 *     property="file_name",
 *     type="string",
 *     example="my-image.png"
 *   ),
 *   @OA\Property(
 *     property="size",
 *     type="integer",
 *     example="31337"
 *   ),
 *   @OA\Property(
 *     property="mime_type",
 *     type="string",
 *     example="image/png"
 *   ),
 *   @OA\Property(
 *     property="url",
 *     type="string",
 *     example="http://localhost/media/my-image.png"
 *   ),
 *   @OA\Property(
 *     property="path",
 *     type="string",
 *     example="/var/www/htdocs/media/my-image.png"
 *   ),
 *   @OA\Property(
 *     property="uuid",
 *     type="string",
 *     example="635b4063-eae8-4d8f-ac45-f29611f5daa0"
 *   ),
 *   @OA\Property(
 *     property="created_at",
 *     type="datetime",
 *     example="2021-04-22 16:23:40"
 *   )
 * )
 */
class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $conversions = [];
        foreach ($this->generated_conversions as $conversion => $status) {
            if ($status) {
                $conversions[$conversion] = asset($this->getUrl($conversion));
            }
        }

        return [
            'collection'  => $this->collection_name,
            'name'        => $this->name,
            'file_name'   => $this->file_name,
            'size'        => (int) $this->size,
            'mime_type'   => $this->mime_type,
            'url'         => $this->getUrl(),
            'path'        => $this->getPath(),
            'uuid'        => $this->uuid,
            'created_at'  => (string) $this->created_at,
            'conversions' => $conversions,
        ];
    }
}

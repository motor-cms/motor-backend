<?php

namespace Motor\Backend\Helpers;

use GuzzleHttp\Psr7\MimeType;
use Spatie\MediaLibrary\HasMedia;

/**
 * Class MediaHelper
 */
class MediaHelper
{
    /**
     * @param \Spatie\MediaLibrary\HasMedia $record
     * @param string $identifier
     * @param bool $base64
     * @param array $conversions
     * @return array
     */
    public static function getFileInformation(
        HasMedia $record,
        string $identifier,
        bool $base64 = false,
        array $conversions = []
    ): array {
        $data = [];
        $items = $record->getMedia($identifier);

        $host = config('app.url');

        //$host = ( isset($_SERVER['HTTPS']) ? "https" : "http" ) . "://".$_SERVER['HTTP_HOST'];

        if (isset($items[0])) {
            $data['file_original'] = asset($items[0]->getUrl());
            $data['file_original_relative'] = str_replace($host, '', asset($items[0]->getUrl()));
            $data['file_size'] = $items[0]->size;
            $data['name'] = $items[0]->name;
            $data['file_name'] = $items[0]->file_name;
            $data['mime_type'] = MimeType::fromFilename($items[0]->file_name);
            $data['is_generating'] = $items[0]->hasCustomProperty('generating');

            if ($base64) {
                $data['file_base64'] = base64_encode(file_get_contents(public_path().urldecode($items[0]->getUrl())));
            }

            foreach ($conversions as $conversion) {
                $data[$conversion] = asset($items[0]->getUrl($conversion));
            }
        }

        return $data;
    }
}

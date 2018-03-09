<?php

namespace Motor\Backend\Helpers;

use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class MediaHelper
{

    public static function getFileInformation(HasMedia $record, $identifier, $base64 = false)
    {
        $data  = [ ];
        $items = $record->getMedia($identifier);
        if (isset( $items[0] )) {
            $data['file_original'] = asset($items[0]->getUrl());
            $data['file_size']     = $items[0]->size;
            $data['mime_type']     = \GuzzleHttp\Psr7\mimetype_from_filename($items[0]->file_name);

            if ($base64) {
                $data['file_base64'] = base64_encode(file_get_contents(public_path() . $items[0]->getUrl()));
            }
        }

        return $data;
    }
}
<?php

namespace App\Helpers;

class GtmHelpers
{
    public static function getGtmAttributesForClickMetaDataEventOnArtwork($item)
    {
        return self::getGtmAttributesFromMetaData(
            array_merge(
                [
                    'event' => 'click-meta-data',
                ],
                self::getMetaDataForArtwork($item)
            )
        );
    }

    public static function getGtmAttributesFromMetaData($metadata)
    {
        return implode(
            ' ',
            array_map(
                function ($key, $value) {
                    return sprintf('data-gtm-%s="%s"', $key, $value);
                },
                array_keys($metadata),
                array_values($metadata)
            )
        );
    }

    public static function getMetaDataForArtwork($item)
    {
        return [
            'type' => 'artwork',
            'public-domain' => $item->is_public_domain,
            'on-view' => $item->is_on_view,
            'collection' => $item->department_title,
            'start-year' => $item->date_start,
            'end-year' => $item->date_end,
            'artist' => $item->artist_title,
            'nationality-location' => $item->place_of_origin,
            'medium' => $item->medium_title,
            'reference-number' => $item->main_reference_number,
        ];
    }
}

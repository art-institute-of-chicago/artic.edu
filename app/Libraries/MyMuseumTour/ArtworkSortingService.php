<?php

namespace App\Libraries\MyMuseumTour;

class ArtworkSortingService
{
    public static function sortArtworksByGallery(&$artworks, $galleryOrder)
    {
        $galleryKeys = array_keys($galleryOrder);
        $defaultPosition = count($galleryOrder);

        usort($artworks, function ($a, $b) use ($galleryKeys, $defaultPosition, $galleryOrder) {
            return self::compareArtworks($a, $b, $galleryKeys, $defaultPosition, $galleryOrder);
        });

        // Append gallery details
        foreach ($artworks as &$artwork) {
            self::appendGalleryDetails($artwork, $galleryOrder);
        }
    }

    private static function compareArtworks($a, $b, $galleryKeys, $defaultPosition, $galleryOrder)
    {
        $posA = self::getArtworkPosition($a, $galleryKeys, $defaultPosition, $galleryOrder);
        $posB = self::getArtworkPosition($b, $galleryKeys, $defaultPosition, $galleryOrder);

        return $posA <=> $posB;
    }

    private static function getArtworkPosition($artwork, $galleryKeys, $defaultPosition, $galleryOrder)
    {
        return array_key_exists('gallery_id', $artwork) && isset($galleryOrder[$artwork['gallery_id']])
            ? array_search($artwork['gallery_id'], $galleryKeys)
            : $defaultPosition;
    }

    private static function appendGalleryDetails(&$artwork, $galleryOrder)
    {
        if (array_key_exists('gallery_id', $artwork) && isset($galleryOrder[$artwork['gallery_id']])) {
            $galleryId = $artwork['gallery_id'];
            $artwork['gallery_title'] = $galleryOrder[$galleryId]['gallery_title'];
            $artwork['gallery_level'] = $galleryOrder[$galleryId]['gallery_level'];
            $artwork['gallery_location'] = $galleryOrder[$galleryId]['gallery_location'];
        }
    }
}

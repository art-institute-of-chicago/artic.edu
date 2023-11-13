<?php

namespace App\Libraries\CustomTour;

class ArtworkSortingService
{
    public static function sortArtworksByGallery(&$artworks, $galleryOrder)
    {
        usort($artworks, function ($a, $b) use ($galleryOrder) {
            $defaultPosition = count($galleryOrder);
            $posA = isset($a['galleryTitle']) ? array_search($a['galleryTitle'], $galleryOrder) : $defaultPosition;
            $posB = isset($b['galleryTitle']) ? array_search($b['galleryTitle'], $galleryOrder) : $defaultPosition;

            return $posA <=> $posB;
        });
    }
}

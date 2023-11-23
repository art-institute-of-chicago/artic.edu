<?php

namespace App\Libraries\CustomTour;

class ArtworkSortingService
{
    public static function sortArtworksByGallery(&$artworks, $galleryOrder)
    {
        usort($artworks, function ($a, $b) use ($galleryOrder) {
            $defaultPosition = count($galleryOrder);
            $posA = isset($a['gallery_id']) ? array_search($a['gallery_id'], $galleryOrder) : $defaultPosition;
            $posB = isset($b['gallery_id']) ? array_search($b['gallery_id'], $galleryOrder) : $defaultPosition;

            return $posA <=> $posB;
        });
    }
}

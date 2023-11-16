<?php

namespace App\Libraries\CustomTour;

class ArtworkSortingService
{
    public static function sortArtworksByGallery(&$artworks, $galleryOrder)
    {
        usort($artworks, function ($a, $b) use ($galleryOrder) {
            $defaultPosition = count($galleryOrder);
            $posA = isset($a['gallery_title']) ? array_search($a['gallery_title'], $galleryOrder) : $defaultPosition;
            $posB = isset($b['gallery_title']) ? array_search($b['gallery_title'], $galleryOrder) : $defaultPosition;

            return $posA <=> $posB;
        });
    }
}

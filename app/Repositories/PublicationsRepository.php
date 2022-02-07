<?php

namespace App\Repositories;

use App\Models\DigitalPublication;
use App\Models\Api\Search;

class PublicationsRepository
{
    public function searchApi($string, $perPage = null, $page = null, $columns = [])
    {
        // Find top-level catalogs that match the search
        $search = Search::query()->search($string)->published()->resources(['digital-catalogs', 'printed-catalogs']);
        $results = $search->getSearch($perPage, $columns, null, $page);

        // Now find matching `sections` and add them to the catalogs
        $searchSections = Search::query()->search($string)->resources(['sections', 'digital-publication-sections']);
        $resultsSections = $searchSections->getSearch(50, $columns, null, $page);

        foreach ($resultsSections as $section) {
            // Get a pub we've already found and add it
            $pub = $results->first(function ($item) use ($section) {
                return $item instanceof DigitalPublication &&
                    ($item->id == $section->generic_page_id || $item->id == $section->publication_id || $item->id == $section->digital_publication_id);
            });
            if ($pub) {
                $pub->addSearchSection($section);
            }

            // If the section represents a pub we haven't found, retrieve it
            else {
                $pub = DigitalPublication::find($section->generic_page_id ?? $section->publication_id ?? $section->digital_publication_id);
                if ($pub) {
                    $pub->addSearchSection($section);
                    $results->push($pub);
                }
            }
        }

        // Map sections to links for display in Global search results
        $results->map(function ($pub) {
            if ($pub instanceof \App\Models\DigitalPublication) {
                $pub->searchSections = collect($pub->searchSections)->take(4);
                $links = [];
                foreach ($pub->searchSections() as $section) {
                    array_push($links, [
                        'href' => $section->web_url,
                        'label' => $section->title,
                    ]);
                }
                $pub['links'] = $links;
            }
            $pub['titleLink'] = $pub->url;
            $pub['image'] = $pub->imageFront('listing');

            return $pub;
        });

        return $results;
    }
}

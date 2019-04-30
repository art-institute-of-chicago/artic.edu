<?php

namespace App\Repositories;

use App\Models\DigitalPublication;
use App\Models\Api\Search;

class PublicationsRepository
{
    public function searchApi($string, $perPage = null, $page = null, $columns = [])
    {
        // Find top-level catalogs that match the search
        $search = Search::query()->search($string)->published()->resources(["digital-publications", "printed-catalogs"]);
        $results = $search->getSearch($perPage, $columns, null, $page);

        // Now find matching `sections` and add them to the catalogs
        $searchSections = Search::query()->search($string)->resources(["sections"]);
        $resultsSections = $searchSections->getSearch($perPage, $columns, null, $page);

        foreach ($resultsSections as $section) {
            // Loop through all the pubs we've already found and add the section
            foreach ($results as $pub) {
                if ($pub instanceof DigitalPublication) {
                    if ($pub->id == $section->generic_page_id) {
                        if (count($pub->sections()) < 4) {
                            $pub->addSection($section);
                        }
                        break;
                    }
                }
            }

            // If the section represents a pub we haven't found, retrieve it
            $dc = DigitalPublication::find($section->generic_page_id);
            if ($dc) {
                $dc->addSection($section);
                $results->merge([$dc]);
            }
        }

        // Map sections to links for display in Global search results
        $results->map(function ($pub) {
            if ($pub instanceof \App\Models\DigitalPublication) {
                $links = [];
                foreach ($pub->sections() as $section) {
                    array_push($links, array(
                        'href' => $section->web_url,
                        'label' => $section->title,
                    ));
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

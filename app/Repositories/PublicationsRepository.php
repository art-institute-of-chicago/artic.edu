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

        // Now find matching `articles` and add them to the catalogs
        $searchArticles = Search::query()->search($string)->resources(['articles', 'digital-publication-articles']);
        $resultsArticles = $searchArticles->getSearch(50, $columns, null, $page);

        foreach ($resultsArticles as $article) {
            // Get a pub we've already found and add it
            $pub = $results->first(function ($item) use ($article) {
                return $item instanceof DigitalPublication &&
                    ($item->id == $article->generic_page_id || $item->id == $article->publication_id || $item->id == $article->digital_publication_id);
            });

            if ($pub) {
                $pub->addSearchArticle($article);
            } else { // If the article represents a pub we haven't found, retrieve it
                $pub = DigitalPublication::find($article->generic_page_id ?? $article->publication_id ?? $article->digital_publication_id);

                if ($pub) {
                    $pub->addSearchArticle($article);
                    $results->push($pub);
                }
            }
        }

        // Map articles to links for display in Global search results
        $results->map(function ($pub) {
            if ($pub instanceof \App\Models\DigitalPublication) {
                $pub->searchArticles = collect($pub->searchArticles)->take(4);
                $links = [];

                foreach ($pub->searchArticles() as $article) {
                    array_push($links, [
                        'href' => $article->web_url,
                        'label' => $article->title,
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

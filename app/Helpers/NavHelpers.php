<?php

use App\Models\GenericPage;

if (!function_exists('get_nav_for_publications')) {
    function get_nav_for_publications(string $title)
    {
        $subNav = [
            [
                'label'  => 'Print Publications',
                'href'   => route('collection.publications.printed-publications'),
                'active' => request()->route()->getName() == 'collection.publications.printed-publications'
            ],
            [
                'label'  => 'Digital Publications',
                'href'   => route('collection.publications.digital-publications'),
                'active' => request()->route()->getName() == 'collection.publications.digital-publications'
            ],
        ];

        $journalPage = GenericPage::forSlug('journal')->published()->first();

        if (isset($journalPage)) {
            $journalPageUrl = $journalPage->url;

            array_push($subNav, [
                'label'  => $journalPage->present()->title,
                'href'   => $journalPageUrl,
                'active' => request()->url() == $journalPageUrl,
            ]);
        }

        $nav = [
            [ 'label' => 'Collection', 'href' => route('collection'), 'links' => $subNav ]
        ];

        $breadcrumb = [
            ['label' => 'The Collection', 'href' => route('collection')],
            ['label' => $title, 'href' => '']
        ];

        return compact('title', 'subNav', 'nav', 'breadcrumb');
    }
}

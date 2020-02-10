<?php

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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*
    Class inherited by PrintedPublications and DigitalPublications
*/

class CatalogsController extends BaseScopedController
{

    protected function getNavElements($title)
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
            ]
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

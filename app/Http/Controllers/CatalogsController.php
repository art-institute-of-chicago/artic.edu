<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*
    Class inherited by PrintedCatalogs and DigitalCatalogs
*/

class CatalogsController extends BaseScopedController
{

    protected function getNavElements($title)
    {
        $subNav = [
            [
                'label'  => 'Printed Catalogues',
                'href'   => route('collection.publications.printed-catalogs'),
                'active' => request()->route()->getName() == 'collection.publications.printed-catalogs'
            ],
            [
                'label'  => 'Digital Catalogues',
                'href'   => route('collection.publications.digital-catalogs'),
                'active' => request()->route()->getName() == 'collection.publications.digital-catalogs'
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

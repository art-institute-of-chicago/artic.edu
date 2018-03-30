<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResearchController extends Controller
{

    public function index()
    {

      return view('statics/research_landing', [
          'primaryNavCurrent' => 'collection',
          'title' => 'The Collection',
          'intro' => 'Explore <em>over 100,000 artworks</em> and information about works of art from all areas in our online encyclopedic collections.',
          'linksBar' => [
              [
                'href' => '#',
                'label' => 'Artworks',
              ],
              [
                'href' => '#',
                'label' => 'Articles & Publications',
              ],
              [
                'href' => '#',
                'label' => 'Research & Resources',
                'active' => true,
              ],
          ],
          'hero' => (object)[
              'image' => null,
              'primary' => 'Primary',
              'secondary' => 'Secondary',
          ],
          'items' => [
              [
                  'image' => null,
                  'title' => 'Libraries',
                  'titleLink' => '#',
                  'text' => 'The Ryerson & Burnham Libraries constitute a major art and architecure research collection service The Art Institute of Chicago...',
                  'links' => [
                      [
                          'href' => '#',
                          'label' => 'Library Catalog',
                          'external' => true,
                      ],
                      [
                          'href' => '#',
                          'label' => 'Library Catalog Help',
                      ]
                  ]
              ],
              [
                  'image' => null,
                  'title' => 'Art & Architecture Archives',
                  'titleLink' => '#',
                  'text' => 'The Archives’ collections are notably strong in late 19th- and 20th-century American architecture, with particular depth...',
              ],
              [
                  'image' => null,
                  'title' => 'Research Guides',
                  'titleLink' => route('collection.resources.research-guides'),
                  'text' => 'When starting your research, explore the guides. To consult with an actual librarian, visit the reference desk...',
                  'links' => [
                      [
                          'href' => '#',
                          'label' => 'Researching Art or Artists',
                      ],
                      [
                          'href' => '#',
                          'label' => 'Researching a Work from the Collections',
                      ],
                      [
                          'href' => '#',
                          'label' => 'Find the Value of a Work of Art',
                      ],
                      [
                          'href' => '#',
                          'label' => 'Find the Value of a Book',
                      ]
                  ]
              ],
              [
                  'image' => null,
                  'title' => 'Scholarly Initiatives',
                  'titleLink' => '#',
                  'text' => 'The Ryerson & Burnham Libraries constitute a major art and architecure research collection service The Art Institute of Chicago...',
              ],
              [
                  'image' => null,
                  'title' => 'Educator Resources',
                  'titleLink' => route('collection.resources.educator-resources'),
                  'text' => 'The Archives’ collections are notably strong in late 19th- and 20th-century American architecture, with particular depth...',
              ],
              [
                  'image' => null,
                  'title' => 'Provenance',
                  'titleLink' => '#',
                  'text' => 'When starting your research, explore the guides. To consult with an actual librarian, visit the reference desk...',
              ],
          ],
          'studyRooms' => [
              [
                  'title' => 'Prints and Drawings',
                  'titleLink' => '#',
                  'text' => 'The Ryerson & Burnham Libraries constitute a major art and architecure research collection service The Art Institute of Chicago...',
              ],
              [
                  'title' => 'Photography',
                  'titleLink' => '#',
                  'text' => 'The Archives’ collections are notably strong in late 19th- and 20th-century American architecture, with particular depth...',
              ],
              [
                  'title' => 'Ryerson Special Collections',
                  'titleLink' => '#',
                  'text' => 'When starting your research, explore the guides. To consult with an actual librarian, visit the reference desk...',
              ],
          ]
      ]);

    }

}

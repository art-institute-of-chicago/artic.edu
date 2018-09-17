<?php

// This has been moved from the model and should be completely refactored
//
// Blocks building are specially overcomplicated.

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;
use App\Helpers\DatesHelpers;
use Carbon\Carbon;

class ArtworkPresenter extends BasePresenter
{
    protected function augmented()
    {
        return $this->entity->getAugmentedModel() ? 'Yes' : 'No';
    }

    public function titleInBucket()
    {
        if ($this->entity->title) {
            return $this->entity->title;
        }

        return 'No title';
    }

    public function headerType()
    {
        return "gallery";
    }

    public function imageThumb()
    {
        $image = $this->entity->imageFront('hero', 'default');

        if (!empty($image)) {
            if (isset($image['src'])) {
                return $image['src'];
            }
        }

    }

    /**
     * Here blocks will be built with all data to be presented properly
     * as it's used by the views.
     * TODO: Views should be refactored for simplicity.
     *
     */
    public function blocks()
    {
        $blocks = [];

        if ($this->entity->description) {
            array_push($blocks, [
              "type"    => 'itemprop',
              "content" => [[
                "type"    => 'text',
                "content" => $this->entity->descriptionFiltered,
              ]],
              'itemprop' => 'description',
            ]);
        }

        if ($this->entity->is_on_view) {
            $dept_link = $this->entity->department_id ? ('<a href="' . route('departments.show', [$this->entity->department_id]) .'" data-gtm-event="' .$this->entity->department_title .'" data-gtm-event-category="collection-nav">' .$this->entity->department_title .'</a></li>') : '';
            $gallery_link = $this->entity->gallery_id ? ('<a href="' .route('galleries.show', [$this->entity->gallery_id]) .'" data-gtm-event="' .$this->entity->gallery_title .'" data-gtm-event-category="collection-nav">' .$this->entity->gallery_title .'</a>') : '';
            array_push($blocks, [
                "type"      => 'deflist',
                "variation" => 'u-hide@large+',
                "ariaOwns"  => "dl-artwork-details",
                "items"     => [
                    [ 'key' => 'On View', 'value' => implode(', ', array($dept_link, $gallery_link)) ],
                ]
            ]);
        }

        array_push($blocks, $this->getArtworkDetailsBlock());

        array_push($blocks, [
            "type" => 'text',
            "content" => '<h2 class="sr-only">Extended information about this artwork</h2>',
        ]);
        array_push($blocks, $this->getArtworkAccordionBlocks());

        array_push($blocks, [
            "type" => 'hr',
        ]);
        array_push($blocks, [
            "type" => 'text',
            "content" => '<p class="f-caption">Object information is a work in progress and may be updated as new research findings emerge. To help improve this record, please email <a data-behavior="maskEmail" data-maskEmail-user="collections" data-maskEmail-domain="artic.edu"></a>.</p>',
        ]);

        return array_filter($blocks);
    }

    protected function getArtworkDetailsBlock()
    {
        $details = [];

        if ($this->entity->artist_pivots != null && count($this->entity->artist_pivots) > 0) {
            $artistLinks = collect($this->entity->artist_pivots)->map(function($item) {
                // Don't show role if the role is "Artist" or [TODO] "Creator"
                $title = $item->artist_title . ( ( $item->role_title && $item->role_id !== 219 ) ? " ({$item->role_title})" : '' );
                return ['label' => $title, 'href' => route('artists.show', ['id' => $item->artist_id]), 'gtmAttributes' => 'data-gtm-event="'. $this->entity->artist_title . '" data-gtm-event-action="' . $this->entity->title . '" data-gtm-event-category="collection-nav"'];
            });
            $details[] = [
                'key'   => str_plural('Artist', count($this->entity->artist_pivots)),
                'links' => $artistLinks,
                'itemprop' => 'creator',
            ];
        } else {
            if ($this->entity->artist_title) {
                $label = $this->entity->artist_title;
                if ($this->entity->artist_id) {
                    $details[] = [
                        'key'   => 'Artist',
                        'links' => [['label' => $label, 'href' => route('artists.show', $this->entity->artist_id), 'gtmAttributes' => 'data-gtm-event="'. $this->entity->artist_title . '" data-gtm-event-action="' . $this->entity->title . '" data-gtm-event-category="collection-nav"']],
                        'itemprop' => 'creator',
                    ];
                } else {
                    $details[] = [
                        'key'   => 'Artist',
                        'value' => $label,
                        'itemprop' => 'creator',
                    ];
                }
            }
        }

        $details = array_merge($details, $this->formatDetailBlocks([
            'Title' => array($this->entity->all_titles,'name')
        ]));

        if ($this->entity->place_pivots != null && count($this->entity->place_pivots) > 0) {
            $places = collect($this->entity->place_pivots)->map(function($item) {
                $title = $item->place_title;
                return  $item->qualifier_title ? $title . " ({$item->qualifier_title})" : $title;
            });

            $details[] = [
                'key'   => str_plural('Place', count($this->entity->place_pivots)),
                'value' => join(', ', $places->toArray()),
                'itemprop' => 'locationCreated',
            ];
        } else {
            if (!empty($this->entity->place_of_origin)) {
                $details[] = [
                    'key' => 'Origin',
                    'value' => $this->entity->place_of_origin,
                    'itemprop' => 'locationCreated',
                ];
            }
        }

        // TODO: Abstract this into a proper method, somewhere appropriate
        $generateDateRangeHref = function( $date_start, $date_end ) {
            return route('collection', [
                'date-start' => abs($date_start) . ( $date_start < 0 ? 'BC' : '' ),
                'date-end' => abs($date_end) . ( $date_end < 0 ? 'BC' : '' ),
            ]);
        };

        if ($this->entity->dates != null && count($this->entity->dates) > 0) {
            $dates = collect($this->entity->dates)->map(function($item) use ($generateDateRangeHref) {

                $date_start = Carbon::parse($item->date_earliest)->year;
                $date_end = Carbon::parse($item->date_latest)->year;

                $joined = join('-', array_unique([convertArtworkDates($date_start), convertArtworkDates($date_end)]));

                return [
                    'label' => join(' ', [ $item->qualifier_title, $joined ] ),
                    'href' => $generateDateRangeHref( $date_start, $date_end ),
                ];
            });
            $details[] = [
                'key'   => str_plural('Date', count($this->entity->dates)),
                'itemprop' => 'dateCreated',
                'links' => $dates,
            ];
        } else {
            if (!empty($this->entity->date_block)) {
                $details[] = [
                    'key' => 'Date',
                    'itemprop' => 'dateCreated',
                    'links' => [[
                        'label' => $this->entity->date_block, // See getDateBlockAttribute
                        'href' => $generateDateRangeHref( $this->entity->date_start, $this->entity->date_end ),
                    ]],
                ];
            }
        }

        $details = array_merge($details, $this->formatDetailBlocks([
            'Medium'           => array($this->entity->medium_display,'material'),
            'Inscriptions'     => array($this->entity->inscriptions),
            'Dimensions'       => array($this->entity->dimensions),
            'Credit Line'      => array($this->entity->credit_line),
            'Reference Number' => array($this->entity->main_reference_number),
            'Copyright'        => array($this->entity->copyright_notice),
        ]));

        return [
            "type"  => 'deflist',
            "items" => $details,
            "id"    => "dl-artwork-details"
        ];
    }

    protected function formatDetailBlocks($elements)
    {
        $blocks = [];

        foreach ($elements as $key => $element) {
            $value = $element[0] ?? null;
            $itemprop = $element[1] ?? null;
            if (!empty($value)) {
                $blocks[] = ['key' => $key, 'value' => $value, 'itemprop' => $itemprop];
            }
        }
        return $blocks;
    }

    protected function buildMultimediaBlocks($resultsByType, $title)
    {
        $block = [
            'title'  => $title,
            'gtmAttributes' => 'data-gtm-event="artwork-open-drawer" data-gtm-event-category="in-page" data-gtm-drawer="'.getUtf8Slug($title).'"',
            'blocks' => []
        ];


        foreach($resultsByType as $type => $medias) {
            $localBlock = [];

            switch ($type) {
                case 'videos':
                    $localBlock = [
                        "type"    => 'listing',
                        "subtype" => 'media',
                        "items"   => $medias,
                    ];
                    break;

                case 'sounds':
                    // A17 WILL NOT SUPPORT MP3's ON PRODUCTION.
                    // This will be passed to the AIC team.
                    if (!\App::environment('production')) {
                        $localBlock = [
                            "type"    => 'listing',
                            "subtype" => 'sound',
                            "items"   => $medias,
                        ];
                    }

                    break;
                case 'sites':
                case 'sections':
                case 'texts':
                    $localBlock = [
                        "type"  => 'link-list',
                        "links" => $medias->toArray(),
                    ];
                    break;
            }

            if (!empty($localBlock)) {
                $block['blocks'][] = $localBlock;
            }
        }

        return $block;
    }

    protected function getArtworkAccordionBlocks()
    {
        $content = $this->formatDescriptionBlocks([
            'publication_history' => 'Publication History',
            'exhibition_history'  => 'Exhibition History',
            'provenance_text'     => 'Provenance'
        ]);

        if ($this->entity->catalogues)
        {
            $rows = $this->entity->catalogues->map(function($item) {
                $content = "Title: {$item->catalogue_title} – Catalogue number: {$item->number} – ID: {$item->catalogue_id}";
                return [
                    "type" => 'text',
                    "content" => '<p>'. $content .'</p>'
                ];
            });

            $block = [
                'title'  => 'Catalogue Raisonnés',
                'blocks' => $rows,
                'gtmAttributes' => 'data-gtm-event="artwork-open-drawer" data-gtm-event-category="in-page" data-gtm-drawer="catalogue-raisonnes"'
            ];

            $content[] = $block;
        }

        if ($this->entity->multimediaElements && $this->entity->multimediaElements->isNotEmpty()) {
            $resultsByType = $this->entity->multimediaElements->groupBy('api_model')->sortKeys();
            $content[] = $this->buildMultimediaBlocks($resultsByType, 'Multimedia');
        }

        if ($this->entity->educationalResources && $this->entity->educationalResources->isNotEmpty())
        {
            $resultsByType = $this->entity->educationalResources->groupBy('api_model')->sort();
            $content[] = $this->buildMultimediaBlocks($resultsByType, 'Educational Resources');
        }

        $content = array_filter($content);

        if (empty($content)) {
            return [];
        } else {
            return [
                "type"    => 'accordion',
                "content" => $content,
                "titleFont" => "f-module-title-2"
            ];
        }
    }

    protected function formatDescriptionBlocks($elements)
    {
        $blocks = [];
        foreach ($elements as $key => $value) {
            if (!empty($this->entity->$key)) {
                $block = array(
                    'title' => $value,
                    'gtmAttributes' => 'data-gtm-event="artwork-open-drawer" data-gtm-event-category="in-page" data-gtm-drawer="'.getUtf8Slug($value).'"',
                    'blocks' => []
                );
                $explodedKeys = explode("\n", $this->entity->$key);
                $blockHtml = '';
                if (count($explodedKeys) < 2) {
                    foreach($explodedKeys as $txt) {
                        if (!empty($txt)) {
                            $blockHtml .= '<p>'.$txt.'</p>';
                        }
                    }
                } else {
                    $blockHtml .= '<ul>';
                    foreach($explodedKeys as $txt) {
                        if (!empty($txt)) {
                            $blockHtml .= '<li>'.$txt.'</li>';
                        }
                    }
                    $blockHtml .= '</ul>';
                }
                $block['blocks'][] = array(
                    "type" => 'text',
                    "content" => $blockHtml
                );
                $blocks[] = $block;
            }
        }

        return $blocks;
    }

    public function buildSchemaItemProps() {
        $itemprops = [
            'accessMode'            => 'visual',
            'alternativeHeadline'   => (!empty($this->entity->alt_titles)) ? implode(', ', $this->entity->alt_titles) : null,
            'contributor'           => (!empty($this->entity->alt_artists)) ? implode(', ', $this->entity->alt_artists) : null,
            'about'                 => (!empty($this->entity->subject_titles)) ? implode(', ', $this->entity->subject_titles) : null,
            'provider'              => $this->entity->department_title,
        ];

        if ($this->entity->thumbnail) {
            $itemprops['thumbnailUrl'] = $this->entity->thumbnail->url.'/full/,150/0/default.jpg';
            $itemprops['image'] = $this->entity->thumbnail->url;
        }

        return $itemprops;
    }
}

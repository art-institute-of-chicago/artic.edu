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
                "content" => $this->entity->description,
              ]],
              'itemprop' => 'description',
            ]);
        }

        if ($this->entity->is_on_view) {
            array_push($blocks, [
                "type"      => 'deflist',
                "variation" => 'deflist--free-spacing u-hide@large+',
                "items"     => [
                    [ 'key' => 'On View', 'value' => $this->entity->isOnViewTitle ],
                ]
            ]);
        }

        array_push($blocks, $this->getArtworkDetailsBlock());
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
                $title = $item->role_title ? $item->artist_title . " ({$item->role_title})" : $item->artist_title;
                return ['label' => $title, 'href' => route('artists.show', $item->artist_id), 'gtmAttributes' => 'data-gtm-event="artist" data-gtm-event-category="collection-nav"'];
            });
            $details[] = [
                'key'   => str_plural('Artist', count($this->entity->artist_pivots)),
                'links' => $artistLinks,
                'itemprop' => 'creator',
            ];
        } else {
            if ($this->entity->artist_id) {
                $label = $this->entity->artist_title ?? $this->entity->artist_display;
                $details[] = [
                    'key'   => 'Artist',
                    'links' => [['label' => $label, 'href' => route('artists.show', $this->entity->artist_id), 'gtmAttributes' => 'data-gtm-event="artist" data-gtm-event-category="collection-nav"']],
                    'itemprop' => 'creator',
                ];
            } else {
                $details[] = [
                    'key'   => 'Artist',
                    'value' => $this->entity->artist_title ?? $this->entity->artist_display,
                    'itemprop' => 'creator',
                ];
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

        if ($this->entity->dates != null && count($this->entity->dates) > 0) {
            $dates = collect($this->entity->dates)->map(function($item) {
                $joined = join(' – ', [convertArtworkDates(Carbon::parse($item->date_earliest)->year), convertArtworkDates(Carbon::parse($item->date_latest)->year)]);
                return join(' ', [$item->qualifier_title, $joined]);
            });

            $details[] = [
                'key'   => str_plural('Date', count($this->entity->dates)),
                'value' => join(', ', $dates->toArray()),
                'itemprop' => 'dateCreated',
            ];
        } else {
            if (!empty($this->entity->date_block)) {
                $details[] = [
                    'key' => 'Date',
                    'value' => $this->entity->date_block,
                    'itemprop' => 'dateCreated',
                ];
            }
        }

        $details = array_merge($details, $this->formatDetailBlocks([
            'Medium'           => array($this->entity->medium_display,'material'),
            'Inscriptions'     => array($this->entity->inscriptions),
            'Dimensions'       => array($this->entity->dimensions),
            'Credit line'      => array($this->entity->credit_line),
            'Reference Number' => array($this->entity->main_reference_number),
            'Copyright'        => array($this->entity->copyright_notice),
        ]));

        return [
            "type"  => 'deflist',
            "items" => $details
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
                case 'sounds':
                    $localBlock = [
                        "type"    => 'listing',
                        "subtype" => 'media',
                        "items"   => $medias,
                    ];
                    break;
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
                $content = "Title: {$item->catalogue_title} - Catalogue number: {$item->number} - ID: {$item->catalogue_id}";
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
                foreach(explode("\n", $this->entity->$key) as $txt) {
                    if (!empty($txt)) {
                        $block['blocks'][] = array(
                            "type" => 'text',
                            "content" => '<p>'.$txt.'</p>'
                        );
                    }
                }
                $blocks[] = $block;
            }
        }

        return $blocks;
    }

    public function buildSchemaItemProps() {
        $itemprops = [];

        $itemprops = array_merge($itemprops, [
            'accessMode'            => 'visual',
            'alternativeHeadline'   =>(isset($this->entity->alt_titles)) ? implode(', ', $this->entity->alt_titles) : null,
            'thumbnailUrl'          => $this->entity->thumbnail->url.'/full/,150/0/default.jpg',
            'image'                 => $this->entity->thumbnail->url,
            'contributor'           => (isset($this->entity->alt_artists)) ? implode(', ', $this->entity->alt_artists) : null,
            'about'                 => (isset($this->entity->subject_titles)) ? implode(', ', $this->entity->subject_titles) : null,
            'provider'              => $this->entity->department_title,
        ]);

        return $itemprops;
    }
}

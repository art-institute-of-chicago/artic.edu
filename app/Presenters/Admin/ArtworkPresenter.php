<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;
use App\Helpers\StringHelpers;
use App\Helpers\DateHelpers;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DamsImageService;
use DOMDocument;

/**
 * This has been moved from the model and should be completely refactored
 *
 * Blocks building are specially overcomplicated.
 */
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
        return 'gallery';
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
                'type' => 'itemprop',
                'content' => [[
                    'type' => 'text',
                    'content' => $this->getFilteredDescription(),
                ]],
                'itemprop' => 'description',
            ]);
        }

        $status = [
            $this->getOnViewDisplay(),
        ];

        if ($this->entity->is_on_view && $this->entity->gallery_id) {
            $status[] = '<a href="' . route('galleries.show', [$this->entity->gallery_id . '/' . StringHelpers::getUtf8Slug($this->entity->gallery_title)]) . '" data-gtm-event="' . $this->entity->gallery_title . '" data-gtm-event-category="collection-nav">' . $this->entity->gallery_title . '</a>';
        }

        $status = implode(', ', $status);
        if ($this->entity->artwork_website_url) {
            $status .= '<div class="m-status f-second-line"><a href="' . $this->entity->artwork_website_url . '" data-gtm-event="artwork website" data-gtm-event-category="collection-nav">Visit artwork website</a></div>';
        }
        $items = [
            [
                'key' => 'Status',
                'value' => $status,
            ],
        ];

        if (!$this->entity->is_deaccessioned && $this->entity->department_id) {
            $items[] = [
                'key' => 'Department',
                'value' => '<a href="' . route('departments.show', [$this->entity->department_id . '/' . StringHelpers::getUtf8Slug($this->entity->department_title)]) . '" data-gtm-event="' . $this->entity->department_title . '" data-gtm-event-category="collection-nav">' . $this->entity->department_title . '</a>',
            ];
        }

        array_push($blocks, [
            'type' => 'deflist',
            'variation' => 'u-hide@large+ sr-show@large+',
            'ariaOwns' => 'dl-artwork-details',
            'items' => $items
        ]);

        array_push($blocks, $this->getArtworkDetailsBlock());

        array_push($blocks, [
            'type' => 'text',
            'content' => '<h2 class="sr-only">Extended information about this artwork</h2>',
        ]);
        array_push($blocks, $this->getArtworkAccordionBlocks());

        array_push($blocks, [
            'type' => 'hr',
        ]);

        array_push($blocks, $this->entity->is_deaccessioned ? [
            'type' => 'text',
            'content' => '<p class="f-caption">Object information is based on information known at time of deaccession and does not reflect any subsequent changes or new research findings about the object.</p>',
        ] : [
            'type' => 'text',
            'content' => '<p class="f-caption">Object information is a work in progress and may be updated as new research findings emerge. To help improve this record, please email <a data-behavior="maskEmail" data-maskEmail-user="collections" data-maskEmail-domain="artic.edu">'
            . (app('printservice')->isPrintMode() ? 'collections@artic.edu' : '')
            . '</a>. Information about image downloads and licensing is <a href="/image-licensing">available here</a>.</p>',
        ]);

        return array_filter($blocks);
    }

    public function getOnViewDisplay()
    {
        if ($this->entity->is_deaccessioned) {
            return 'Deaccessioned';
        }

        if ($this->entity->is_on_view) {
            return 'On View';
        }

        if ($this->entity->on_loan_display) {
            return $this->entity->on_loan_display;
        }

        return 'Currently Off View';
    }

    private function getFilteredDescription()
    {
        $html = strip_tags($this->entity->description, [
            'a',
            'p',
            'br',
            'em',
            'strong',
            'table',
            'thead',
            'tbody',
            'tr',
            'td',
        ]);

        // https://stackoverflow.com/questions/1685277
        $oldInternalErrors = libxml_use_internal_errors(true);

        $doc = new DOMDocument();
        $doc->loadHTML('<?xml encoding="utf-8" ?>' . $html);

        foreach ($doc->getElementsByTagName('table') as $table) {
            $tempHtml = view('components.molecules._m-table', [
                'tableHtml' => '<table>' . $doc->saveHTML($table) . '</table>',
            ])->render();

            $fragment = $doc->createDocumentFragment();
            $fragment->appendXML($tempHtml);

            $table->parentNode->replaceChild($fragment, $table);
        }

        $result = $doc->saveHTML($doc->documentElement);

        libxml_clear_errors();
        libxml_use_internal_errors($oldInternalErrors);

        return $result;
    }

    /**
     * $item must contain artist_id, artist_title, role_id, role_title
     */
    private function getArtistLink($pivot)
    {
        $label = $pivot->artist_title;

        // Don't show role if the role is "Artist" or "Culture"
        if (isset($pivot->role_title) && isset($pivot->role_id) && !in_array($pivot->role_id, [219, 555])) {
            $label .= ' (' . $pivot->role_title . ')';
        }

        // Don't show link if the artwork is deaccessioned
        if ($this->entity->is_deaccessioned) {
            $href = null;
        } else {
            $href = route('artists.show', $pivot->artist_id . '/' . StringHelpers::getUtf8Slug($pivot->artist_title));
        }

        return [
            'label' => $label,
            'href' => $href,
            'gtmAttributes' => 'data-gtm-event="' . $pivot->artist_title . '"'
                . ' data-gtm-event-category="collection-nav"',
        ];
    }

    protected function getIiifManifestUrl()
    {
        return str_replace('-', '&#8209;', config('api.public_uri') . '/api/v1/artworks/' . $this->entity->id . '/manifest.json');
    }

    protected function getArtworkDetailsBlock()
    {
        $details = [];

        if ($this->entity->artist_pivots != null && count($this->entity->artist_pivots) > 0) {
            $artistPivots = collect($this->entity->artist_pivots)->filter(function ($item) {
                // WEB-118, WEB-1026: Ensure that all relationships point to existing items
                return isset($item->artist_id) && isset($item->artist_title);
            });

            $preferredArtist = $artistPivots->firstWhere('is_preferred', true)
                ?: $artistPivots->firstWhere('preferred', true);

            $showCultureFirst = false;

            $cultureLinks = [];
            $artistLinks = [];

            if ($preferredArtist) {
                // Remove this item from the pivot list so it doesn't get duplicated
                $artistPivots = $artistPivots->filter(function ($item) use ($preferredArtist) {
                    return $item != $preferredArtist;
                });

                $preferredArtistLink = $this->getArtistLink($preferredArtist);

                if ($preferredArtist->role_id === 555) {
                    $showCultureFirst = true;
                    $cultureLinks[] = $preferredArtistLink;
                } else {
                    $artistLinks[] = $preferredArtistLink;
                }
            }

            $artistPivots->filter(function ($item) {
                return $item->role_id === 555;
            })->each(function ($item) use (&$cultureLinks) {
                $cultureLinks[] = $this->getArtistLink($item);
            });

            $artistPivots->filter(function ($item) {
                return $item->role_id !== 555;
            })->each(function ($item) use (&$artistLinks) {
                $artistLinks[] = $this->getArtistLink($item);
            });

            if ($showCultureFirst) {
                if (count($cultureLinks) > 0) {
                    $details[] = [
                        'key' => Str::plural('Culture', count($cultureLinks)),
                        'links' => $cultureLinks,
                        'itemprop' => 'creator',
                    ];
                }
                if (count($artistLinks) > 0) {
                    $details[] = [
                        'key' => Str::plural('Artist', count($artistLinks)),
                        'links' => $artistLinks,
                        'itemprop' => 'creator',
                    ];
                }
            } else {
                if (count($artistLinks) > 0) {
                    $details[] = [
                        'key' => Str::plural('Artist', count($artistLinks)),
                        'links' => $artistLinks,
                        'itemprop' => 'creator',
                    ];
                }
                if (count($cultureLinks) > 0) {
                    $details[] = [
                        'key' => Str::plural('Culture', count($cultureLinks)),
                        'links' => $cultureLinks,
                        'itemprop' => 'creator',
                    ];
                }
            }
        }

        $details = array_merge($details, $this->formatDetailBlocks([
            'Title' => [$this->entity->all_titles, 'name']
        ]));

        if ($this->entity->place_pivots != null && count($this->entity->place_pivots) > 0) {
            $places = collect($this->entity->place_pivots)->map(function ($item) {
                $title = $item->place_title;

                return  $item->qualifier_title ? $title . " ({$item->qualifier_title})" : $title;
            });

            $details[] = [
                'key' => Str::plural('Place', count($this->entity->place_pivots)),
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

        // WEB-2267: Abstract this into a proper method, somewhere appropriate
        $generateDateRangeHref = function ($date_start, $date_end) {
            return route('collection', [
                'date-start' => abs($date_start) . ($date_start < 0 ? 'BCE' : ''),
                'date-end' => abs($date_end) . ($date_end < 0 ? 'BCE' : ''),
            ]);
        };

        if ($this->entity->dates != null && count($this->entity->dates) > 0) {
            $dates = collect($this->entity->dates)->map(function ($item) use ($generateDateRangeHref) {
                $date_start = Carbon::parse($item->date_earliest)->year;
                $date_end = Carbon::parse($item->date_latest)->year;

                $joined = join('-', array_unique([DateHelpers::convertArtworkDates($date_start), DateHelpers::convertArtworkDates($date_end)]));

                return [
                    'label' => join(' ', [$item->qualifier_title, $joined]),
                    'href' => $generateDateRangeHref($date_start, $date_end),
                ];
            });
            $details[] = [
                'key' => Str::plural('Date', count($this->entity->dates)),
                'itemprop' => 'dateCreated',
                'links' => $dates,
            ];
        } else {
            if (!empty($this->entity->date_block)) {
                $details[] = [
                    'key' => 'Date',
                    'itemprop' => 'dateCreated',
                    'links' => [[
                        'label' => join(' ', [($this->entity->date_qualifier_title ?? ''), $this->entity->date_block]), // @see getDateBlockAttribute
                        'href' => $generateDateRangeHref($this->entity->date_start, $this->entity->date_end),
                    ]],
                ];
            }
        }

        $details = array_merge($details, $this->formatDetailBlocks([
            'Medium' => [$this->entity->medium_display, 'material'],
            'Inscriptions' => [$this->entity->inscriptions],
            'Dimensions' => [$this->entity->dimensions, 'size'],
            'Credit Line' => [$this->entity->credit_line],
            'Reference Number' => [$this->entity->main_reference_number, 'identifier'],
            'Copyright' => [$this->entity->copyright_notice],
        ]));

        if ($this->entity->is_public_domain) {
            $details = array_merge($details, $this->formatDetailBlocks([
                '<span id="h-iiif-manifest">IIIF Manifest</span>&nbsp;'
                    . '<button class="info-button-trigger" data-behavior="infoButtonTrigger" aria-label="Info" aria-expanded="false" data-breakpoints="none">'
                    . '    <svg class="icon--info"><use xlink:href="#icon--info" /></svg>'
                    . '</button>'
                    . '<span class="info-button-info s-hidden" id="info-button-info-iiif-manifest" data-behavior="infoButtonInfo">'
                    . '    <span class="f-caption">'
                    . '        The International Image Interoperability Framework (IIIF) represents a set of open standards that enables rich access to digital media from libraries, archives, museums, and other cultural institutions around the world.<br/><br/>'
                    . '        <a href="/open-access/open-access-images">Learn more</a>.'
                    . '    </span>'
                    . '</span>' => [$this->getIiifManifestUrl()],
            ]));
        }

        return [
            'type' => 'deflist',
            'items' => $details,
            'id' => 'dl-artwork-details'
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
            'title' => $title,
            'gtmAttributes' => 'data-gtm-event="artwork-open-drawer" data-gtm-event-category="in-page" data-gtm-drawer="' . StringHelpers::getUtf8Slug($title) . '"',
            'blocks' => []
        ];

        $localBlock = [
            'type' => 'link-list',
            'links' => [],
        ];

        foreach ($resultsByType as $type => $medias) {
            $localBlock['links'] = array_merge($localBlock['links'], $medias->toArray());
        }

        if (!empty($localBlock['links'])) {
            $block['blocks'][] = $localBlock;
        }


        return $block;
    }

    protected function getArtworkAccordionBlocks()
    {
        $content = $this->formatDescriptionBlocks([
            'publication_history' => 'Publication History',
            'exhibition_history' => 'Exhibition History',
            'provenance_text' => 'Provenance'
        ]);

        if ($this->entity->catalogue_display) {
            $content[] = [
                'title' => 'Catalogues Raisonnés',
                'blocks' => [
                    [
                        'type' => 'text',
                        'content' => $this->entity->catalogue_display
                    ],
                ],
                'gtmAttributes' => 'data-gtm-event="artwork-open-drawer" data-gtm-event-category="in-page" data-gtm-drawer="catalogue-raisonnes"'
            ];
        }

        if ($this->entity->multimediaResources && $this->entity->multimediaResources->isNotEmpty()) {
            $resultsByType = $this->entity->multimediaResources->groupBy('api_model')->sortKeys();
            $content[] = $this->buildMultimediaBlocks($resultsByType, 'Multimedia');
        }

        if ($this->entity->educationalResources && $this->entity->educationalResources->isNotEmpty()) {
            $resultsByType = $this->entity->educationalResources->groupBy('api_model')->sort();
            $content[] = $this->buildMultimediaBlocks($resultsByType, 'Educational Resources');
        }

        $content = array_filter($content);

        if (empty($content)) {
            return [];
        }

            return [
                'type' => 'accordion',
                'content' => $content,
                'titleFont' => 'f-module-title-2'
            ];

    }

    protected function formatDescriptionBlocks($elements)
    {
        $blocks = [];
        foreach ($elements as $key => $value) {
            if (!empty($this->entity->{$key})) {
                $block = [
                    'title' => $value,
                    'gtmAttributes' => 'data-gtm-event="artwork-open-drawer" data-gtm-event-category="in-page" data-gtm-drawer="' . StringHelpers::getUtf8Slug($value) . '"',
                    'blocks' => []
                ];
                $explodedKeys = explode("\n", $this->entity->{$key});
                $blockHtml = '';
                if (count($explodedKeys) < 2) {
                    foreach ($explodedKeys as $txt) {
                        if (!empty($txt)) {
                            $blockHtml .= '<p>' . $txt . '</p>';
                        }
                    }
                } else {
                    $blockHtml .= '<ul>';
                    foreach ($explodedKeys as $txt) {
                        if (!empty($txt)) {
                            $blockHtml .= '<li>' . $txt . '</li>';
                        }
                    }
                    $blockHtml .= '</ul>';
                }
                $block['blocks'][] = [
                    'type' => 'text',
                    'content' => $blockHtml
                ];
                $blocks[] = $block;
            }
        }

        return $blocks;
    }

    public function buildSchemaItemProps()
    {
        $itemprops = [
            'accessMode' => 'visual',
            'alternativeHeadline' => (!empty($this->entity->alt_titles)) ? implode(', ', $this->entity->alt_titles) : null,
            'contributor' => (!empty($this->entity->alt_artists)) ? implode(', ', $this->entity->alt_artists) : null,
            'about' => (!empty($this->entity->subject_titles)) ? implode(', ', $this->entity->subject_titles) : null,
            'provider' => $this->entity->department_title,
        ];

        if ($this->entity->image_id) {
            $itemprops['thumbnailUrl'] = DamsImageService::getBaseUrl() . '2/' . $this->entity->image_id . '/full/200,/0/default.jpg';
            $itemprops['image'] = DamsImageService::getBaseUrl() . '2/' . $this->entity->image_id;
        }

        return $itemprops;
    }
}

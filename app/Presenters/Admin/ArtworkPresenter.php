<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;
use App\Helpers\StringHelpers;
use App\Helpers\DateHelpers;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DOMDocument;

/**
 * This has been moved from the model and should be completely refactored
 *
 * Blocks building are specially overcomplicated.
 */
class ArtworkPresenter extends BasePresenter
{
    public function augmented()
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

        array_push($blocks, $this->getTabbedTombstoneBlock());

        return array_filter($blocks);
    }

    /**
     * The single object-information caption shared by the tabbed tombstone footer.
     */
    protected function getObjectInformationCaption()
    {
        if ($this->entity->is_deaccessioned) {
            return '<p class="f-caption">Object information is based on information known at time of deaccession and does not reflect any subsequent changes or new research findings about the object.</p>';
        }

        return '<p class="f-caption">Object information is a work in progress and may be updated as new research findings emerge. To help improve this record, please email <a data-behavior="maskEmail" data-maskEmail-user="collections" data-maskEmail-domain="artic.edu">'
            . (app('printservice')->isPrintMode() ? 'collections@artic.edu' : '')
            . '</a>.</p>';
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
                    ];
                }

                if (count($artistLinks) > 0) {
                    $details[] = [
                        'key' => Str::plural('Artist', count($artistLinks)),
                        'links' => $artistLinks,
                    ];
                }
            } else {
                if (count($artistLinks) > 0) {
                    $details[] = [
                        'key' => Str::plural('Artist', count($artistLinks)),
                        'links' => $artistLinks,
                    ];
                }

                if (count($cultureLinks) > 0) {
                    $details[] = [
                        'key' => Str::plural('Culture', count($cultureLinks)),
                        'links' => $cultureLinks,
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

                return $item->qualifier_title ? $title . " ({$item->qualifier_title})" : $title;
            });

            $details[] = [
                'key' => Str::plural('Place', count($this->entity->place_pivots)),
                'value' => join(', ', $places->toArray()),
            ];
        } else {
            if (!empty($this->entity->place_of_origin)) {
                $details[] = [
                    'key' => 'Origin',
                    'value' => $this->entity->place_of_origin,
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
                'links' => $dates,
            ];
        } else {
            if (!empty($this->entity->date_block)) {
                $details[] = [
                    'key' =>
                    <<<VALUE
                        <span id="h-date-disclaimer">Date</span>&nbsp;
                        <button class="info-button-trigger" data-behavior="infoButtonTrigger" aria-label="Info" aria-expanded="false" data-breakpoints="none">
                        <svg class="icon--info"><use xlink:href="#icon--info" /></svg>
                        </button>
                        <span class="info-button-info s-hidden" id="info-button-info-date-disclaimer" data-behavior="infoButtonInfo">
                        <span class="f-caption">
                                Dates are not always precisely known, but the Art Institute strives to present this information as consistently and legibly as possible. Dates may be represented as a range that spans decades, centuries, dynasties, or periods and may include qualifiers such as c. (circa) or BCE.
                            </span>
                        </span>
                    VALUE,
                    'links' => [[
                        'label' => join(' ', [($this->entity->date_qualifier_title ?? ''), $this->entity->date_block]), // @see getDateBlockAttribute
                        'href' => $generateDateRangeHref($this->entity->date_start, $this->entity->date_end),
                    ]],
                ];
            }
        }

        $details = array_merge($details, $this->formatDetailBlocks([
            'Medium' => [$this->entity->medium_display, 'material'],
            'Edition' => [$this->entity->edition],
            'Inscriptions' => [$this->entity->inscriptions],
            'Dimensions' => [$this->entity->dimensions, 'size'],
            'Credit Line' => [$this->entity->credit_line],
            'Reference Number' => [$this->entity->main_reference_number, 'identifier'],
            'Copyright' => [$this->entity->copyright_notice],
        ]));

        if ($this->entity->is_public_domain) {
            $details = array_merge($details, $this->formatDetailBlocks([
                <<<VALUE
                    <span id="h-iiif-manifest">IIIF Manifest</span>&nbsp;
                    <button class="info-button-trigger" data-behavior="infoButtonTrigger" aria-label="Info" aria-expanded="false" data-breakpoints="none">
                        <svg class="icon--info"><use xlink:href="#icon--info" /></svg>
                    </button>
                    <span class="info-button-info s-hidden" id="info-button-info-iiif-manifest" data-behavior="infoButtonInfo">
                        <span class="f-caption">
                            The International Image Interoperability Framework (IIIF) represents a set of open standards that enables rich access to digital media from libraries, archives, museums, and other cultural institutions around the world.<br/><br/>
                        <a href="/open-access/open-access-images">Learn more</a>.
                        </span>
                    </span>
                VALUE => [$this->getIiifManifestUrl()],
            ]));
        }

        return [
            'type' => 'deflist',
            'items' => $details,
            'id' => 'dl-artwork-details'
        ];
    }

    /**
     * Builds the single "tabbed-tombstone" block rendered on the artwork page.
     * Overview is always present; every other tab is omitted when it has no data.
     */
    public function getTabbedTombstoneBlock()
    {
        $tabs = [
            $this->getTabbedTombstoneOverviewTab(),
        ];

        $longFormTabs = [
            ['id' => 'publication-history', 'label' => 'Publication History', 'value' => $this->entity->publication_history],
            ['id' => 'catalogues-raisonnes', 'label' => 'Catalogues Raisonnés', 'value' => $this->entity->catalogue_display],
            ['id' => 'exhibition-history', 'label' => 'Exhibition History', 'value' => $this->entity->exhibition_history],
            ['id' => 'provenance', 'label' => 'Provenance', 'value' => $this->entity->provenance_text],
        ];

        foreach ($longFormTabs as $longFormTab) {
            $tab = $this->getTabbedTombstoneTextTab($longFormTab['id'], $longFormTab['label'], $longFormTab['value']);

            if ($tab) {
                $tabs[] = $tab;
            }
        }

        $apiTab = $this->getTabbedTombstoneApiTab();

        if ($apiTab) {
            $tabs[] = $apiTab;
        }

        return [
            'type' => 'tabbed-tombstone',
            'tabs' => array_values(array_filter($tabs)),
            'caption' => $this->getObjectInformationCaption(),
        ];
    }

    protected function getTabbedTombstoneOverviewTab()
    {
        $detailsBlock = $this->getArtworkDetailsBlock();

        $rows = [];

        foreach ($detailsBlock['items'] as $item) {
            // The IIIF manifest belongs to the API & linked data tab only.
            if (trim($this->tabbedTombstonePlainText($item['key'])) === 'IIIF Manifest') {
                continue;
            }

            $value = $this->formatTabbedTombstoneDetailValue($item);

            if (empty($value)) {
                continue;
            }

            $rows[] = [
                'key' => $this->tabbedTombstonePlainText($item['key']),
                'value' => $this->formatTabbedTombstoneOverviewValue($item, $value),
            ];
        }

        // Department lives in the mobile status deflist, but the tabbed tombstone
        // surfaces it on desktop too. Placed after Credit Line, before Reference Number.
        $departmentRow = $this->getTabbedTombstoneDepartmentRow();

        if ($departmentRow) {
            $insertAt = count($rows);

            foreach ($rows as $index => $row) {
                if ($row['key'] === 'Credit Line') {
                    $insertAt = $index + 1;
                    break;
                }
            }

            if ($insertAt === count($rows)) {
                foreach ($rows as $index => $row) {
                    if ($row['key'] === 'Reference Number') {
                        $insertAt = $index;
                        break;
                    }
                }
            }

            array_splice($rows, $insertAt, 0, [$departmentRow]);
        }

        return [
            'id' => 'overview',
            'label' => 'Overview',
            'kind' => 'keyvalue',
            'rows' => $rows,
            'copy' => $this->getTabbedTombstoneOverviewCopy(),
            'hasCopy' => true,
        ];
    }

    /**
     * Clipboard payload for the Overview tab: bare values, one per line, in the
     * order the design specifies. Field titles are intentionally omitted.
     */
    protected function getTabbedTombstoneOverviewCopy()
    {
        $entity = $this->entity;

        $lines = [
            data_get($entity, 'artist_display'),
            $this->tabbedTombstoneCopyLine([
                data_get($entity, 'title'),
                data_get($entity, 'date_display'),
            ]),
            data_get($entity, 'place_of_origin'),
            data_get($entity, 'medium_display'),
            data_get($entity, 'artwork_website_url'),
            data_get($entity, 'edition'),
            data_get($entity, 'inscriptions'),
            data_get($entity, 'watermarks'),
            data_get($entity, 'dimensions'),
            data_get($entity, 'credit_line'),
            data_get($entity, 'copyright_notice'),
            $this->tabbedTombstoneCopyLine([
                data_get($entity, 'department_title'),
                data_get($entity, 'main_reference_number'),
            ]),
        ];

        $lines = array_map(function ($line) {
            return trim(preg_replace('/\s+/', ' ', $this->tabbedTombstonePlainText((string) $line)));
        }, $lines);

        return implode("\n", array_filter($lines, function ($line) {
            return $line !== '';
        }));
    }

    /**
     * Joins copy values on a single line, dropping empty ones.
     */
    protected function tabbedTombstoneCopyLine(array $parts)
    {
        $parts = array_filter(array_map(function ($part) {
            return trim((string) $part);
        }, $parts), function ($part) {
            return $part !== '';
        });

        return implode(', ', $parts);
    }

    /**
     * A single line renders as prose, two or more as a bulleted list.
     */
    protected function getTabbedTombstoneTextTab($id, $label, $value)
    {
        if (empty($value)) {
            return null;
        }

        $lines = explode("\n", $value);
        $rows = [];

        foreach ($lines as $line) {
            if (!empty($line)) {
                $rows[] = ['content' => $line];
            }
        }

        if (empty($rows)) {
            return null;
        }

        return [
            'id' => $id,
            'label' => $label,
            'kind' => count($lines) < 2 ? 'prose' : 'list',
            'rows' => $rows,
            'copy' => '',
            'hasCopy' => false,
        ];
    }

    protected function getTabbedTombstoneApiTab()
    {
        $rows = [];

        $apiUrl = $this->entity->api_link ?? null;

        if (empty($apiUrl)) {
            $apiUrl = config('api.public_uri') . '/api/v1/artworks/' . $this->entity->id;
        }

        if (!empty($apiUrl)) {
            $rows[] = $this->formatTabbedTombstoneLinkedRow('API', $apiUrl);
        }

        if ($this->entity->is_public_domain) {
            $manifestUrl = $this->getIiifManifestUrl();

            if (!empty($manifestUrl)) {
                $rows[] = $this->formatTabbedTombstoneLinkedRow(
                    'IIIF Manifest',
                    str_replace('&#8209;', '-', $manifestUrl),
                    $manifestUrl
                );
            }
        }

        $ulanId = $this->getTabbedTombstoneArtistUlanId();

        if (!empty($ulanId)) {
            $rows[] = $this->formatTabbedTombstoneLinkedRow('Artist ULAN', 'https://vocab.getty.edu/ulan/' . $ulanId);
        }

        if (empty($rows)) {
            return null;
        }

        return [
            'id' => 'api-and-linked-data',
            'label' => 'API and Linked Data',
            'kind' => 'keyvalue',
            'rows' => $rows,
            'copy' => implode("\n", array_column($rows, 'copy')),
            'hasCopy' => true,
        ];
    }

    protected function formatTabbedTombstoneLinkedRow($key, $url, $display = null)
    {
        $displayUrl = $display ?? $url;
        $displayUrl = str_replace('/', '/&#8203;', $displayUrl);

        return [
            'key' => $key,
            'value' => '<a href="' . $url . '">' . $displayUrl . '</a>',
            'kind' => 'linked',
            'copy' => $url,
        ];
    }

    protected function getTabbedTombstoneArtistUlanId()
    {
        $artists = [];

        if (!empty($this->entity->artist_pivots)) {
            foreach ($this->entity->artist_pivots as $pivot) {
                $artists[] = $pivot;
            }
        }

        if (!empty($this->entity->artists)) {
            foreach ($this->entity->artists as $artist) {
                $artists[] = $artist;
            }
        }

        foreach ($artists as $artist) {
            if (!empty($artist->ulan_id)) {
                return $artist->ulan_id;
            }
        }

        return null;
    }

    /**
     * Artist rows show the API's `artist_display` (name plus nationality and
     * dates, e.g. "Georges Seurat (French, 1859-1891)") while keeping the
     * existing artist link.
     */
    protected function formatTabbedTombstoneOverviewValue($item, $value)
    {
        $key = $this->tabbedTombstonePlainText($item['key']);
        $links = $item['links'] ?? [];
        $artistDisplay = $this->entity->artist_display ?? null;

        if (strpos($key, 'Artist') !== 0 || count($links) !== 1 || empty($artistDisplay) || !is_string($artistDisplay)) {
            return $value;
        }

        $link = $links[0];

        if (empty($link['label']) || strpos($artistDisplay, $link['label']) === false) {
            return $value;
        }

        if (empty($link['href'])) {
            return e($artistDisplay);
        }

        return '<a href="' . $link['href'] . '"'
            . (!empty($link['gtmAttributes']) ? ' ' . $link['gtmAttributes'] : '')
            . '>' . e($artistDisplay) . '</a>';
    }

    protected function formatTabbedTombstoneDetailValue($item)
    {
        if (!empty($item['links'])) {
            $parts = [];

            foreach ($item['links'] as $link) {
                $label = $link['label'] ?? null;

                if (empty($label)) {
                    continue;
                }

                if (!empty($link['href'])) {
                    $parts[] = '<a href="' . $link['href'] . '"'
                        . (!empty($link['gtmAttributes']) ? ' ' . $link['gtmAttributes'] : '')
                        . '>' . $label . '</a>';
                } else {
                    $parts[] = $label;
                }
            }

            return implode(', ', $parts);
        }

        return $item['value'] ?? '';
    }

    protected function getTabbedTombstoneDepartmentRow()
    {
        if ($this->entity->is_deaccessioned || !$this->entity->department_id) {
            return null;
        }

        return [
            'key' => 'Department',
            'value' => '<a href="' . route('departments.show', [$this->entity->department_id . '/' . StringHelpers::getUtf8Slug($this->entity->department_title)]) . '" data-gtm-event="' . $this->entity->department_title . '" data-gtm-event-category="collection-nav">' . $this->entity->department_title . '</a>',
        ];
    }

    /**
     * Plain, unstyled text for the clipboard: removes interactive info buttons
     * (and their hidden tooltips), strips markup and decodes entities.
     */
    protected function tabbedTombstonePlainText($html)
    {
        if (empty($html)) {
            return '';
        }

        $html = preg_replace('/<(button|span)\b[^>]*(?:info-button-trigger|info-button-info|s-hidden)[^>]*>.*?<\/\1>/is', '', $html);

        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = str_replace("\xC2\xA0", ' ', $text);
        // Drop zero-width break characters added for URL wrapping.
        $text = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $text);

        return trim(preg_replace('/\s+/', ' ', $text));
    }

    protected function formatDetailBlocks($elements)
    {
        $blocks = [];

        foreach ($elements as $key => $element) {
            $value = $element[0] ?? null;

            if (!empty($value)) {
                $blocks[] = ['key' => $key, 'value' => $value];
            }
        }

        return $blocks;
    }
}

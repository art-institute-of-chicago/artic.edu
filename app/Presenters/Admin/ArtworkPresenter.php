<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

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
              "type"    => 'text',
              "content" => $this->entity->description
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

        return array_filter($blocks);
    }

    protected function getArtworkDetailsBlock()
    {
        $details = [];

        if ($this->entity->artist_pivots != null && count($this->entity->artist_pivots) > 0) {
            $artistLinks = collect($this->entity->artist_pivots)->map(function($item) {
                return ['label' => $item->artist_title, 'href' => route('artists.show', $item->artist_id)];
            });
            $details[] = [
                'key'   => str_plural('Artist', count($this->entity->artist_pivots)),
                'links' => $artistLinks
            ];
        }

        if ($this->entity->place_pivots != null && count($this->entity->place_pivots) > 0) {
            $places = collect($this->entity->place_pivots)->pluck('place_title')->toArray();
            $details[] = [
                'key'   => str_plural('Place', count($this->entity->place_pivots)),
                'value' => join(', ', $places)
            ];
        }

        if (!empty($this->entity->place_of_origin)) {
            $details[] = [
                'key' => 'Origin',
                'value' => $this->entity->place_of_origin
            ];
        }

        if (!empty($this->entity->alt_titles)) {
            $details[] = [
                'key' => 'Alternate Names',
                'value' => join($this->entity->alt_titles, ', ')
            ];
        }

        $details = array_merge($details, $this->formatDetailBlocks([
            'Date'             => $this->entity->date_display,
            'Medium'           => $this->entity->medium,
            'Dimensions'       => $this->entity->dimensions,
            'Credit line'      => $this->entity->credit_line,
            'Reference Number' => $this->entity->main_reference_number,
            'Copyright'        => $this->entity->copyright_notice,
        ]));

        return [
            "type"  => 'deflist',
            "items" => $details
        ];
    }

    protected function formatDetailBlocks($elements)
    {
        $blocks = [];
        foreach ($elements as $key => $value) {
            if (!empty($value)) {
                $blocks[] = ['key' => $key, 'value' => $value];
            }
        }

        return $blocks;
    }

    protected function buildMultimediaBlocks($resultsByType, $title)
    {
        $block = [
            'title'  => $title,
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

        if ($this->entity->multimediaElements && !$this->entity->multimediaElements->isEmpty()) {
            $resultsByType = $this->entity->multimediaElements->groupBy('api_model')->sortKeys();
            $content[] = $this->buildMultimediaBlocks($resultsByType, 'Multimedia');
        }

        if ($this->entity->educationalResources && !$this->entity->educationalResources->isEmpty())
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
                "content" => $content
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

}

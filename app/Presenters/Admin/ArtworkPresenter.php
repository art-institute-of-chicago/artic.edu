<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class ArtworkPresenter extends BasePresenter
{
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

    public function blocks()
    {
        $blocks = [];

        if (!empty($this->entity->description)) {
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
        array_push($blocks, $this->getArtworkDescriptionBlocks());

        return array_filter($blocks);
    }

    protected function getArtworkDetailsBlock()
    {
        $details = [];

        if ($this->entity->artists != null && $this->entity->artists->count() > 0) {
            $details[] = [
                'key' => str_plural('Artist', $this->entity->artists->count()),
                'value' => $this->entity->artists->implode('title', ', ')
            ];
        } else {
            if (!empty($this->entity->place_of_origin)) {
                $details[] = [
                    'key' => 'Origin',
                    'value' => $this->entity->place_of_origin
                ];
            }
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

    protected function getArtworkDescriptionBlocks()
    {
        $content = $this->formatDescriptionBlocks([
            'publication_history' => 'Publication History',
            'exhibition_history'  => 'Exhibition History',
            'provenance_text'     => 'Provenance'
        ]);

        if ($this->entity->multimediaElements && !$this->entity->multimediaElements->isEmpty()) {
            $items = [];
            foreach($this->entity->multimediaElements as $media) {
                $media->title = $media->publication_title;
                $media->slug = $media->web_url;
                $items[] = $media;
            }

            $block = array(
                'title' => 'Multimedia',
                'blocks' => [
                    [
                        "type"    => 'listing',
                        "subtype" => 'media',
                        "items"   => $items,
                    ]
                ]
            );

            $content[] = $block;
        }

        if ($this->entity->resources && !$this->entity->resources->isEmpty()) {
            $items = [];
            foreach($this->entity->resources as $resource) {
                $items[] = [
                    'label' => $resource->publication_title,
                    'href'  => $resource->web_url
                ];
            }

            $block = array(
                'title' => 'Educational Resources',
                'blocks' => [
                    [
                        "type"  => 'link-list',
                        "links" => $items,
                    ]
                ]
            );

            $content[] = $block;
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

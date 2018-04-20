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
        array_push($blocks, array(
          "type" => 'text',
          "content" => $this->entity->description
        ));

        if ($this->entity->is_on_view) {
            $label = '';
            if (!empty($this->entity->collection_status)) {
                $label .= $this->entity->collection_status . ', ';
            }
            if (!empty($this->entity->gallery_title)) {
                $label .= $this->entity->gallery_title;
            }
            $this->entity->onView = array('label' => $label, 'href' => route('galleries.show', [$this->entity->gallery_id]));

            array_push($blocks, array(
              "type" => 'deflist',
              "variation" => 'deflist--free-spacing u-hide@large+',
              "items" => array(
                array('key' => 'On View', 'value' => $label),
              )
            ));
        }

        array_push($blocks, $this->getArtworkDetailsBlock());
        array_push($blocks, $this->getArtworkDescriptionBlocks());

        return $blocks;
    }

    public function getArtworkDetailsBlock()
    {

        $details = [];

        if ($this->entity->artists != null && $this->entity->artists->count() > 0) {
            $details[] = array('key' => str_plural('Artist', $this->entity->artists->count()), 'value' => $this->entity->artists->implode('title', ', '));
        } else {
            if (!empty($this->entity->place_of_origin)) {
                $details[] = array('key' => 'Origin', 'value' => $this->entity->place_of_origin);
            }
        }

        if (!empty($this->entity->alt_titles)) {
            $details[] = array('key' => 'Alternate Names', 'value' => join($this->entity->alt_titles, ', '));
        }
        if (!empty($this->entity->date_display)) {
            $details[] = array('key' => 'Date', 'value' => $this->entity->date_display);
        }
        if (!empty($this->entity->medium)) {
            $details[] = array('key' => 'Medium', 'value' => $this->entity->medium);
        }
        if (!empty($this->entity->dimensions)) {
            $details[] = array('key' => 'Dimensions', 'value' => $this->entity->dimensions);
        }
        if (!empty($this->entity->credit_line)) {
            $details[] = array('key' => 'Credit line', 'value' => $this->entity->credit_line);
        }
        if (!empty($this->entity->main_reference_number)) {
            $details[] = array('key' => 'Reference Number', 'value' => $this->entity->main_reference_number);
        }
        if (!empty($this->entity->copyright_notice)) {
            $details[] = array('key' => 'Copyright', 'value' => $this->entity->copyright_notice);
        }

        $block = array(
          "type"  => 'deflist',
          "items" => $details
        );

        return $block;
    }

    public function getArtworkDescriptionBlocks()
    {
        $blocks = [];

        $content = [];
        if (!empty($this->entity->publication_history)) {
            $block = array(
                'title' => 'Publication History',
                'blocks' => []
            );
            foreach(explode("\n", $this->entity->publication_history) as $txt) {
                if (!empty($txt)) {
                    $block['blocks'][] = array(
                        "type" => 'text',
                        "content" => '<p>'.$txt.'</p>'
                    );
                }
            }
            $content[] = $block;
        }

        if (!empty($this->entity->exhibition_history)) {
            $block = array(
                'title' => 'Exhibition History',
                'blocks' => []
            );
            foreach(explode("\n", $this->entity->exhibition_history) as $txt) {
                if (!empty($txt)) {
                    $block['blocks'][] = array(
                        "type" => 'text',
                        "content" => '<p>'.$txt.'</p>'
                    );
                }
            }
            $content[] = $block;
        }

        if (!empty($this->entity->provenance_text)) {
            $block = array(
                'title' => 'Provenance',
                'blocks' => []
            );
            foreach(explode("\n", $this->entity->provenance_text) as $txt) {
                if (!empty($txt)) {
                    $block['blocks'][] = array(
                        "type" => 'text',
                        "content" => '<p>'.$txt.'</p>'
                    );
                }
            }
            $content[] = $block;
        }

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
                        "type" => 'listing',
                        "subtype" => 'media',
                        "items" => $items,
                    ]
                ]
            );

            $content[] = $block;
        }

        if ($this->entity->resources && !$this->entity->resources->isEmpty()) {

            $items = [];
            foreach($this->entity->resources as $resource) {
                $items[] = array('label' => $resource->publication_title, 'href' => $resource->web_url);
            }

            $block = array(
                'title' => 'Educational Resources',
                'blocks' => [
                    [
                        "type" => 'link-list',
                        "links" => $items,
                    ]
                ]
            );

            $content[] = $block;
        }


        $blocks = array(
            "type" => 'accordion',
            "content" => $content
        );

        return $blocks;
    }

}

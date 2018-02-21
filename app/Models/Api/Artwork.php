<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class Artwork extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/artworks',
        'resource'   => '/api/v1/artworks/{id}',
        'search'     => '/api/v1/artworks/search'
    ];

    public function artists()
    {
        return $this->hasMany(\App\Models\Api\Artist::class, 'alt_artist_ids');
    }

    public function getSlugAttribute()
    {
        return route('artworks.show', $this->id);
    }

    public function getArtworkDetailsBlock()
    {

        $details = [];

        if ($this->artists != null && $this->artists->count() > 0) {
            $details[] = array('key' => 'Artist', 'value' => $this->artists->implode('title', ', '));
        } else {
            if (!empty($this->place_of_origin)) {
                $details[] = array('key' => 'Origin', 'value' => $this->place_of_origin);
            }
        }

        if (!empty($this->date_display)) {
            $details[] = array('key' => 'Date', 'value' => $this->date_display);
        }
        if (!empty($this->medium)) {
            $details[] = array('key' => 'Medium', 'value' => $this->medium);
        }
        if (!empty($this->dimensions)) {
            $details[] = array('key' => 'Dimensions', 'value' => $this->dimensions);
        }
        if (!empty($this->credit_line)) {
            $details[] = array('key' => 'Credit line', 'value' => $this->credit_line);
        }
        if (!empty($this->main_reference_number)) {
            $details[] = array('key' => 'Reference Number', 'value' => $this->main_reference_number);
        }
        if (!empty($this->copyright_notice)) {
            $details[] = array('key' => 'Copyright', 'value' => $this->copyright_notice);
        }

        $block = array(
          "type" => 'deflist',
          "items" =>$details
        );

        return $block;
    }

    public function getArtworkDescriptionBlocks()
    {
        $blocks = [];

        $content = [];
        if (!empty($this->publication_history)) {
            $block = array(
                'title' => 'Publication History',
                'blocks' => []
            );
            foreach(explode("\n", $this->publication_history) as $txt) {
                if (!empty($txt)) {
                    $block['blocks'][] = array(
                        "type" => 'text',
                        "content" => '<p>'.$txt.'</p>'
                    );
                }
            }
            $content[] = $block;
        }

        if (!empty($this->exhibition_history)) {
            $block = array(
                'title' => 'Exhibition History',
                'blocks' => []
            );
            foreach(explode("\n", $this->exhibition_history) as $txt) {
                if (!empty($txt)) {
                    $block['blocks'][] = array(
                        "type" => 'text',
                        "content" => '<p>'.$txt.'</p>'
                    );
                }
            }
            $content[] = $block;
        }

        if (!empty($this->provenance_text)) {
            $block = array(
                'title' => 'Provenance',
                'blocks' => []
            );
            foreach(explode("\n", $this->provenance_text) as $txt) {
                if (!empty($txt)) {
                    $block['blocks'][] = array(
                        "type" => 'text',
                        "content" => '<p>'.$txt.'</p>'
                    );
                }
            }
            $content[] = $block;
        }

        $blocks = array(
            "type" => 'accordion',
            "content" => $content
        );

        return $blocks;
    }
}

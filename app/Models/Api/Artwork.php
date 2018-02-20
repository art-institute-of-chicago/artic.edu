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

        if ($this->artists->count() > 0) {
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
}

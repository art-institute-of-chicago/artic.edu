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
        return $this->hasMany(\App\Models\Api\Artist::class, 'artist_ids');
    }

    public function getSlugAttribute()
    {
        return route('artworks.show', $this->id);
    }

    public function getArtworkDetailsBlock()
    {

        $details = [];
        $details[] = array('key' => 'Artist', 'value' => 'The Artist Name');
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

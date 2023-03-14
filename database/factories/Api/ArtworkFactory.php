<?php

namespace Database\Factories\Api;

use App\Models\Api\Artwork;

class ArtworkFactory extends ApiFactory
{
    public $model = Artwork::class;

    public function definition(): array
    {
        return [
            "alt_titles" => null,
            "artwork_agents" => null,
            "artwork_dates" => null,
            "collection_status" => "Permanent Collection",
            "committees" => [],
            "copyright" => "",
            "copyright_ids" => [],
            "creator_display" => "Chris Killip",
            "creator_id" => 13854,
            "credit_line" => "Gift of Helen Harvey Mills",
            "date_display" => "1973",
            "date_end" => 1973,
            "date_qualifier_id" => 4,
            "date_start" => 1973,
            "department_id" => 20,
            "description" => "",
            "edition" => "12 of 25",
            "exhibitions" => null,
            "fiscal_year" => null,
            "fiscal_year_deaccession" => null,
            "gallery_id" => 0,
            "has_rights_web_educational" => false,
            "inscriptions" => null,
            "is_on_view" => false,
            "is_public_domain" => false,
            "main_id" => "1978.1106a",
            "medium" => "Gelatin silver print, No. 1 from the portfolio \"Isle of Man\" (1973)",
            "modified_at" => "2022-11-07T22:23:53.235Z",
            "object_type" => "Photograph",
            "object_type_id" => 2,
            "place_of_origin" => "England",
            "provenance" => null,
            "publications" => null,
            "publishing_verification_level" => "Web Basic",
            "visual_description" => "",
            'api_model' => 'artworks',
            'artist_display' => null,
            'artist_pivots' => null,
            'artist_title' => null,
            'date_display' => null,
            'id' => $this->faker->randomNumber(nbDigits: 5),
            'image_id' => null,
            'main_reference_number' => null,
            'thumbnail' => null,
            'title' => ucfirst($this->faker->words(5, true)),
        ];
    }
}

<?php

namespace Tests\Unit\Stubs;

class StubArtwork
{
    public $id = 1;

    public $title = 'Starry Night';

    public $main_reference_number = '1234';

    public $artist_title = 'Vincent van Gogh';

    public $date_display = '1889';

    public $medium_display = 'Oil on canvas';

    public $dimensions = '73.7 × 92.1 cm';

    public $artwork_type_title = 'Painting';

    public $place_of_origin = 'France';

    public $credit_line = 'Gift of Example';

    public $description = '<p>A starry night scene.</p>';

    public $copyright_notice = 'Public domain';

    public $subject_titles = ['Landscape'];

    public $style_titles = ['Post-Impressionism'];

    public $category_titles = ['Painting'];

    public $classification_title = 'Painting';

    public $department_title = 'Arts of the Americas';

    public $gallery_title = 'Gallery 100';

    public $dimensions_detail = [
        ['width' => 73.7, 'height' => 92.1, 'depth' => null, 'unit' => 'cm'],
    ];

    public $titleSlug = 'starry-night';

    public function imageFront($role = 'hero', $crop = null)
    {
        return [
            'src' => 'https://lakeimagesweb.artic.edu/iiif/2/abc/full/!3000,3000/0/default.jpg',
            'iiifId' => 'https://lakeimagesweb.artic.edu/iiif/2/abc',
        ];
    }
}

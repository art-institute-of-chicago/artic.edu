<?php

namespace Tests\Unit\Stubs;

class StubArtist
{
    public $id = 8;

    public $title = 'Vincent van Gogh';

    public $agent_type = 'Individual';

    public $birth_date = '1853-03-30';

    public $death_date = '1890-07-29';

    public $birth_place = 'Zundert';

    public $nationality = 'Dutch';

    public $description = '<p>A Dutch post-impressionist painter.</p>';

    public $ulan_uri = 'http://vocab.getty.edu/page/ulan/500115588';

    public $titleSlug = 'vincent-van-gogh';

    public function imageFront($role = 'hero', $crop = null)
    {
        return ['src' => 'https://lakeimagesweb.artic.edu/iiif/2/artist/full/!3000,3000/0/default.jpg'];
    }
}

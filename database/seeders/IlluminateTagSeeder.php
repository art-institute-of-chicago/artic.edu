<?php

namespace Database\Seeders;

use Cartalyst\Tags\IlluminateTag;
use Illuminate\Database\Seeder;

class IlluminateTagSeeder extends Seeder
{
    public function run(): void
    {
        $tag = new IlluminateTag();
        $tag->name = 'Restrict Download';
        $tag->slug = 'restrict-download';
        $tag->namespace = 'media';
        $tag->save();
    }
}

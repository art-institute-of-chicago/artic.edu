<?php

namespace Database\Seeders;

use App\Models\EventProgram;
use Illuminate\Database\Seeder;

class EventProgramSeeder extends Seeder
{
    private $programs = [
        'Artist’s Studio',
        'Family Festivals',
        'Picture This',
        'Artful Play',

        'American Sign Language Tours',
        'Artists Connect',
        'Conversations and Panel Discussions',
        'Highlights',
        'Modern Wing Highlights',
        'Intersections',
        'Lectures',
        'Verbal Description Tours',

        'Art History Mini-Courses',
        'Sketch Classes and Workshops',
        'Community Associates',

        'Antiquarian Society',
        'Architecture & Design Society',
        'Asian Art Council',
        'Classical Art Society',
        'Evening Associates',
        'Old Masters Society',
        'Photography Associates',
        'Print and Drawing Club',
        'Society for Contemporary Art',
        'Textile Society',
        'Woman’s Board',

        'Accessibility',
        'Conservation and Science',
        'Luminary',
        'Gallery Talks',
    ];

    public function run(): void
    {
        foreach ($this->programs as $item) {
            $program = EventProgram::firstOrNew(['name' => $item]);

            $program->save();
        }
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\EventProgram;

class AddEventProgramsData extends Migration
{

    private $programs = [
        "Artist’s Studio",
        "Family Festivals",
        "Picture This",
        "Artful Play",

        "American Sign Language Tours",
        "Artists Connect",
        "Conversations and Panel Discussions",
        "Highlights",
        "Modern Wing Highlights",
        "Intersections",
        "Lectures",
        "Verbal Description Tours",

        "Art History Mini-Courses",
        "Sketch Classes and Workshops",
        "Community Associates",

        "Antiquarian Society",
        "Architecture & Design Society",
        "Asian Art Council",
        "Classical Art Society",
        "Evening Associates",
        "Old Masters Society",
        "Photography Associates",
        "Print and Drawing Club",
        "Society for Contemporary Art",
        "Textile Society",
        "Woman’s Board",

        "Accessibility",
        "Conservation and Science",
        "Sustaining Fellows",
        "Gallery Talks",
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        foreach ($this->programs as $item)
        {
            $program = EventProgram::firstOrNew(['name' => $item]);

            $program->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        foreach ($this->programs as $item)
        {
            $program = EventProgram::where('name', $item)->first();

            if ($program)
            {
                $program->delete();
            }
        }

    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\EventProgram;

class RenameSustainingFellowsEventProgram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $program = EventProgram::where('name', 'Sustaining Fellows')->first();
        $program->name = 'Luminary';
        $program->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $program = EventProgram::where('name', 'Luminary')->first();
        $program->name = 'Sustaining Fellows';
        $program->save();
    }
}

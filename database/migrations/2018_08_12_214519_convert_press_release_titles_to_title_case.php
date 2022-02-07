<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\PressRelease;

class ConvertPressReleaseTitlesToTitleCase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $all = PressRelease::all();

        foreach ($all as $pressRelease) {
            $pressRelease->title = StringHelpers::properTitleCase($pressRelease->title);
            $pressRelease->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}

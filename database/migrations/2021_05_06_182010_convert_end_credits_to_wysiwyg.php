<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\Slide;

class ConvertEndCreditsToWysiwyg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $slides = Slide::where('module_type', 'end')->get();

        foreach ($slides as $slide) {
            if ($slide->end_credit_copy) {
                $slide->end_credit_copy = '<p>' . $slide->end_credit_copy . '</p>';
                $slide->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wysiwyg', function (Blueprint $table) {

        });
    }
}

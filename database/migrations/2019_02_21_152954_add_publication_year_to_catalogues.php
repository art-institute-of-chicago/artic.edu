<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublicationYearToCatalogues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('printed_catalogs', function (Blueprint $table) {
            $table->integer('publication_year')->default(0);
        });

        Schema::table('digital_catalogs', function (Blueprint $table) {
            $table->integer('publication_year')->default(0);
        });

        // Extract the publication year from the page text and populate the new field.

        // TODO: Using models in migrations causes too much trouble:
        // SQLSTATE[42S02]: Base table or view not found: 1146 Table 'aic_dl.printed_publications' doesn't exist
        // (SQL: select * from `printed_publications` where `published` = 1 and `printed_publications`.`deleted_at` is null)

        // foreach (['App\Models\PrintedPublication', 'App\Models\DigitalPublication'] as $catalogClass) {
        //     foreach ($catalogClass::where('published', TRUE)->get() as $catalog) {

        //         // If the first block is a Split Block
        //         if ($catalog->blocks[0]->type == 'split_block') {

        //             $start = strpos($catalog->blocks[0]->content['paragraph'], '<p>');
        //             $end = strpos($catalog->blocks[0]->content['paragraph'], '</p>', $start);
        //             $paragraph = strip_tags(substr($catalog->blocks[0]->content['paragraph'], $start, $end-$start+4));

        //             // And the first sentence is like "The Art Institute of Chicago, XXXX"
        //             if (preg_match('/^The Art Institute of Chicago, [0-9]+/', $paragraph)) {
        //                 $year = (int) filter_var($paragraph, FILTER_SANITIZE_NUMBER_INT);
        //                 $catalog->publication_year = $year;
        //                 $catalog->save();
        //             }
        //         }
        //     }
        // }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('printed_catalogs', function (Blueprint $table) {
            $table->dropColumn('publication_year');
        });

        Schema::table('digital_catalogs', function (Blueprint $table) {
            $table->dropColumn('publication_year');
        });
    }
}

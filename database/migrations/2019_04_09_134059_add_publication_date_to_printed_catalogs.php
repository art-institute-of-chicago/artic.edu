<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Carbon\Carbon;
use App\Models\PrintedPublication;

class AddPublicationDateToPrintedCatalogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('printed_catalogs', function (Blueprint $table) {
            $table->date('publication_date')->nullable()->after('publication_year');
        });

        foreach (PrintedPublication::all() as $catalog) {
            $catalog->publication_date = empty($catalog->publication_year) ? null : (new Carbon())
                ->year($catalog->publication_year)
                ->month(1)
                ->day(1)
                ->startOfDay();
            $catalog->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('printed_catalogs', function (Blueprint $table) {
            $table->dropColumn('publication_date');
        });
    }
}

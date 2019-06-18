<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePolymorphicRelationsForPublicationsRename extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::update("update activity_log set subject_type = 'digitalPublications' where subject_type = ?", ['App\Models\DigitalCatalog']);
        DB::update("update activity_log set causer_type = 'digitalPublications' where causer_type = ?", ['App\Models\DigitalCatalog']);
        DB::update("update api_relatables set api_relatable_type = 'digitalPublications' where api_relatable_type = ?", ['App\Models\DigitalCatalog']);
        DB::update("update blocks set blockable_type = 'digitalPublications' where blockable_type = ?", ['App\Models\DigitalCatalog']);
        DB::update("update categorized set categorizable_type = 'digitalPublications' where categorizable_type = ?", ['App\Models\DigitalCatalog']);
        DB::update("update experience_images set imagable_type = 'digitalPublications' where imagable_type = ?", ['App\Models\DigitalCatalog']);
        DB::update("update experience_modals set modalble_type = 'digitalPublications' where modalble_type = ?", ['App\Models\DigitalCatalog']);
        DB::update("update features set featured_type = 'digitalPublications' where featured_type = ?", ['App\Models\DigitalCatalog']);
        DB::update("update fileables set fileable_type = 'digitalPublications' where fileable_type = ?", ['App\Models\DigitalCatalog']);
        DB::update("update mediables set mediable_type = 'digitalPublications' where mediable_type = ?", ['App\Models\DigitalCatalog']);
        DB::update("update related set subject_type = 'digitalPublications' where subject_type = ?", ['App\Models\DigitalCatalog']);
        DB::update("update related set related_type = 'digitalPublications' where related_type = ?", ['App\Models\DigitalCatalog']);
        DB::update("update site_tagged set site_taggable_type = 'digitalPublications' where site_taggable_type = ?", ['App\Models\DigitalCatalog']);
        DB::update("update tagged set taggable_type = 'digitalPublications' where taggable_type = ?", ['App\Models\DigitalCatalog']);

        DB::update("update activity_log set subject_type = 'printedPublications' where subject_type = ?", ['App\Models\PrintedCatalog']);
        DB::update("update activity_log set causer_type = 'printedPublications' where causer_type = ?", ['App\Models\PrintedCatalog']);
        DB::update("update api_relatables set api_relatable_type = 'printedPublications' where api_relatable_type = ?", ['App\Models\PrintedCatalog']);
        DB::update("update blocks set blockable_type = 'printedPublications' where blockable_type = ?", ['App\Models\PrintedCatalog']);
        DB::update("update categorized set categorizable_type = 'printedPublications' where categorizable_type = ?", ['App\Models\PrintedCatalog']);
        DB::update("update experience_images set imagable_type = 'printedPublications' where imagable_type = ?", ['App\Models\PrintedCatalog']);
        DB::update("update experience_modals set modalble_type = 'printedPublications' where modalble_type = ?", ['App\Models\PrintedCatalog']);
        DB::update("update features set featured_type = 'printedPublications' where featured_type = ?", ['App\Models\PrintedCatalog']);
        DB::update("update fileables set fileable_type = 'printedPublications' where fileable_type = ?", ['App\Models\PrintedCatalog']);
        DB::update("update mediables set mediable_type = 'printedPublications' where mediable_type = ?", ['App\Models\PrintedCatalog']);
        DB::update("update related set subject_type = 'printedPublications' where subject_type = ?", ['App\Models\PrintedCatalog']);
        DB::update("update related set related_type = 'printedPublications' where related_type = ?", ['App\Models\PrintedCatalog']);
        DB::update("update site_tagged set site_taggable_type = 'printedPublications' where site_taggable_type = ?", ['App\Models\PrintedCatalog']);
        DB::update("update tagged set taggable_type = 'printedPublications' where taggable_type = ?", ['App\Models\PrintedCatalog']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::update("update activity_log set subject_type = 'App\Models\DigitalCatalog' where subject_type = ?", ['digitalPublications']);
        DB::update("update activity_log set causer_type = 'App\Models\DigitalCatalog' where causer_type = ?", ['digitalPublications']);
        DB::update("update api_relatables set api_relatable_type = 'App\Models\DigitalCatalog' where api_relatable_type = ?", ['digitalPublications']);
        DB::update("update blocks set blockable_type = 'App\Models\DigitalCatalog' where blockable_type = ?", ['digitalPublications']);
        DB::update("update categorized set categorizable_type = 'App\Models\DigitalCatalog' where categorizable_type = ?", ['digitalPublications']);
        DB::update("update experience_images set imagable_type = 'App\Models\DigitalCatalog' where imagable_type = ?", ['digitalPublications']);
        DB::update("update experience_modals set modalble_type = 'App\Models\DigitalCatalog' where modalble_type = ?", ['digitalPublications']);
        DB::update("update features set featured_type = 'App\Models\DigitalCatalog' where featured_type = ?", ['digitalPublications']);
        DB::update("update fileables set fileable_type = 'App\Models\DigitalCatalog' where fileable_type = ?", ['digitalPublications']);
        DB::update("update mediables set mediable_type = 'App\Models\DigitalCatalog' where mediable_type = ?", ['digitalPublications']);
        DB::update("update related set subject_type = 'App\Models\DigitalCatalog' where subject_type = ?", ['digitalPublications']);
        DB::update("update related set related_type = 'App\Models\DigitalCatalog' where related_type = ?", ['digitalPublications']);
        DB::update("update site_tagged set site_taggable_type = 'App\Models\DigitalCatalog' where site_taggable_type = ?", ['digitalPublications']);
        DB::update("update tagged set taggable_type = 'App\Models\DigitalCatalog' where taggable_type = ?", ['digitalPublications']);

        DB::update("update activity_log set subject_type = 'App\Models\PrintedCatalog' where subject_type = ?", ['printedPublications']);
        DB::update("update activity_log set causer_type = 'App\Models\PrintedCatalog' where causer_type = ?", ['printedPublications']);
        DB::update("update api_relatables set api_relatable_type = 'App\Models\PrintedCatalog' where api_relatable_type = ?", ['printedPublications']);
        DB::update("update blocks set blockable_type = 'App\Models\PrintedCatalog' where blockable_type = ?", ['printedPublications']);
        DB::update("update categorized set categorizable_type = 'App\Models\PrintedCatalog' where categorizable_type = ?", ['printedPublications']);
        DB::update("update experience_images set imagable_type = 'App\Models\PrintedCatalog' where imageble_type = ?", ['printedPublications']);
        DB::update("update experience_modals set modalble_type = 'App\Models\PrintedCatalog' where modalble_type = ?", ['printedPublications']);
        DB::update("update features set featured_type = 'App\Models\PrintedCatalog' where featured_type = ?", ['printedPublications']);
        DB::update("update fileables set fileable_type = 'App\Models\PrintedCatalog' where fileable_type = ?", ['printedPublications']);
        DB::update("update mediables set mediable_type = 'App\Models\PrintedCatalog' where mediable_type = ?", ['printedPublications']);
        DB::update("update related set subject_type = 'App\Models\PrintedCatalog' where subject_type = ?", ['printedPublications']);
        DB::update("update related set related_type = 'App\Models\PrintedCatalog' where related_type = ?", ['printedPublications']);
        DB::update("update site_tagged set site_taggable_type = 'App\Models\PrintedCatalog' where site_taggable_type = ?", ['printedPublications']);
        DB::update("update tagged set taggable_type = 'App\Models\PrintedCatalog' where taggable_type = ?", ['printedPublications']);
    }
}

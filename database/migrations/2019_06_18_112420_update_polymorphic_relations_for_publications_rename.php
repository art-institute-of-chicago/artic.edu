<?php

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
        $this->renameMorphTypes('App\Models\DigitalCatalog', 'digitalPublications');
        $this->renameMorphTypes('App\Models\PrintedCatalog', 'printedPublications');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->renameMorphTypes('digitalPublications', 'App\Models\DigitalCatalog');
        $this->renameMorphTypes('printedPublications', 'App\Models\PrintedCatalog');
    }

    /**
     * This function represents the all polymorphic tables as they exist at the time of this migration.
     * TODO: Abstract it out to a generic helper? Might be harmless to do so.
     */
    private function renameMorphTypes($from, $to)
    {
        DB::update('update activity_log set subject_type = ? where subject_type = ?', [$to, $from]);
        DB::update('update activity_log set causer_type = ? where causer_type = ?', [$to, $from]);
        DB::update('update api_relatables set api_relatable_type = ? where api_relatable_type = ?', [$to, $from]);
        DB::update('update blocks set blockable_type = ? where blockable_type = ?', [$to, $from]);
        DB::update('update categorized set categorizable_type = ? where categorizable_type = ?', [$to, $from]);
        DB::update('update experience_images set imagable_type = ? where imagable_type = ?', [$to, $from]);
        DB::update('update experience_modals set modalble_type = ? where modalble_type = ?', [$to, $from]);
        DB::update('update features set featured_type = ? where featured_type = ?', [$to, $from]);
        DB::update('update fileables set fileable_type = ? where fileable_type = ?', [$to, $from]);
        DB::update('update mediables set mediable_type = ? where mediable_type = ?', [$to, $from]);
        DB::update('update related set subject_type = ? where subject_type = ?', [$to, $from]);
        DB::update('update related set related_type = ? where related_type = ?', [$to, $from]);
        DB::update('update site_tagged set site_taggable_type = ? where site_taggable_type = ?', [$to, $from]);
        DB::update('update tagged set taggable_type = ? where taggable_type = ?', [$to, $from]);
    }
}

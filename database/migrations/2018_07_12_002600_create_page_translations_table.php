<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'page');
            $table->string('visit_intro')->nullable();
            $table->string('visit_hour_header')->nullable();
            $table->string('visit_hour_subheader')->nullable();
            $table->string('visit_city_pass_title')->nullable();
            $table->text('visit_city_pass_text')->nullable();
            $table->string('visit_city_pass_button_label')->nullable();
            $table->text('visit_admission_description')->nullable();
            $table->string('visit_buy_tickets_label')->nullable();
            $table->string('visit_become_member_label')->nullable();
        });

        $visitPage = \App\Models\Page::where('type', 3)->select('id')->first();

        if ($visitPage) {
            DB::table('page_translations')->insert([
                'locale' => 'en',
                'active' => true,
                'page_id' => $visitPage->id,
                'visit_intro' => $visitPage->visit_intro,
                'visit_hour_header' => $visitPage->visit_hour_header,
                'visit_hour_subheader' => $visitPage->visit_hour_subheader,
                'visit_city_pass_title' => $visitPage->visit_city_pass_title,
                'visit_city_pass_text' => $visitPage->visit_city_pass_text,
                'visit_city_pass_button_label' => $visitPage->visit_city_pass_button_label,
                'visit_admission_description' => $visitPage->visit_admission_description,
                'visit_buy_tickets_label' => $visitPage->visit_buy_tickets_label,
                'visit_become_member_label' => $visitPage->visit_become_member_label,
            ]);
        }

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('visit_intro');
            $table->dropColumn('visit_hour_header');
            $table->dropColumn('visit_hour_subheader');
            $table->dropColumn('visit_city_pass_title');
            $table->dropColumn('visit_city_pass_text');
            $table->dropColumn('visit_city_pass_button_label');
            $table->dropColumn('visit_admission_description');
            $table->dropColumn('visit_buy_tickets_label');
            $table->dropColumn('visit_become_member_label');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_translations');
        Schema::table('pages', function (Blueprint $table) {
            $table->string('visit_intro')->nullable();
            $table->string('visit_hour_header')->nullable();
            $table->string('visit_hour_subheader')->nullable();
            $table->string('visit_city_pass_title')->nullable();
            $table->text('visit_city_pass_text')->nullable();
            $table->string('visit_city_pass_button_label')->nullable();
            $table->text('visit_admission_description')->nullable();
            $table->string('visit_buy_tickets_label')->nullable();
            $table->string('visit_become_member_label')->nullable();
        });
    }
}

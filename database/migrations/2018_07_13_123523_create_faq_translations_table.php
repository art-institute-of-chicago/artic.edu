<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq_translations', function (Blueprint $table) {
            createDefaultTranslationsTableFields($table, 'faq');
            $table->string('title')->nullable();
        });

        foreach (\App\Models\Faq::all() as $faq) {
            foreach (config('translatable.locales') as $locale) {
                DB::table('faq_translations')->insert([
                    'locale' => $locale,
                    'active' => true,
                    'faq_id' => $faq->id,
                    'title' => $faq->title,
                ]);
            }
        }

        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('title');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_translations');
        Schema::table('faqs', function (Blueprint $table) {
            $table->string('title')->nullable();
        });
    }
}

<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\GenericPage;
use App\Models\VanityRedirect;

class MoveRedirectsFromGenericPagesToVanityRedirectModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Get all the Generic Pages that have a redirect in place
        $existingRedirects = GenericPage::published()->whereNotNull('redirect_url')->get();

        // Generate vanity redirects based on them
        foreach ($existingRedirects as $genericPage) {
            $redirect = VanityRedirect::firstOrNew(['path' => Str::after($genericPage->getUrl(), '/')]);
            $redirect->destination = Str::startsWith($genericPage->redirect_url, '/') ? Str::after($genericPage->redirect_url, '/') : $genericPage->redirect_url;
            $redirect->published = TRUE;
            $redirect->save();
        }

        // We'll leave all the generic pages in place and leave it to
        // content folks to manually delete the irrelevant ones
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

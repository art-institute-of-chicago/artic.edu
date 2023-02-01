<?php

namespace Database\Seeders;

use App\Models\GenericPage;
use App\Models\VanityRedirect;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VanityRedirectSeeder extends Seeder
{
    public function run(): void
    {
        // XXX Without the generic pages seeded as well, this won't work as intended. I'm guessing there some vanity
        // urls that are required to make the app function properly. Can we hardcode them here?

        // Get all the Generic Pages that have a redirect in place
        $existingRedirects = GenericPage::published()->whereNotNull('redirect_url')->get();

        // Generate vanity redirects based on them
        foreach ($existingRedirects as $genericPage) {
            $redirect = VanityRedirect::firstOrNew(['path' => Str::after($genericPage->getUrl(), '/')]);
            $redirect->destination = Str::startsWith($genericPage->redirect_url, '/')
                ? Str::after($genericPage->redirect_url, '/')
                : $genericPage->redirect_url;
            $redirect->published = true;
            $redirect->save();
        }

        // We'll leave all the generic pages in place and leave it to
        // content folks to manually delete the irrelevant ones
    }
}

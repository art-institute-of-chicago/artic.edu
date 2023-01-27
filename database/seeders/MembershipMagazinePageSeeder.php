<?php

namespace Database\Seeders;

use App\Models\GenericPage;
use Illuminate\Database\Seeder;

class MembershipMagazinePageSeeder extends Seeder
{
    public function run(): void
    {
        $page = new GenericPage();
        $page->title = 'Member Magazine';
        $page->redirect_url = '/magazine';
        $page->published = true;
        $parent = GenericPage::where('title', 'Membership')->first();
        $page->parent_id = $parent->id;
        $page->save();
    }
}

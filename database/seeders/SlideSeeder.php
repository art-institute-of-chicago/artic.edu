<?php

namespace Database\Seeders;

use App\Models\Slide;
use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    public function run()
    {
        // XXX Without these slides already seeded, this update is moot.
        // Even if slides are necessary to run the app, this seems like good
        // functionality to test.
        $slides = Slide::where('module_type', 'end')->get();

        foreach ($slides as $slide) {
            if ($slide->end_credit_copy) {
                $slide->end_credit_copy = '<p>' . $slide->end_credit_copy . '</p>';
                $slide->save();
            }
        }
    }
}

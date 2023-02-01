<?php

namespace Database\Seeders;

use App\Models\Slide;
use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    public function run()
    {
        $slides = Slide::where('module_type', 'end')->get();

        foreach ($slides as $slide) {
            if ($slide->end_credit_copy) {
                $slide->end_credit_copy = '<p>' . $slide->end_credit_copy . '</p>';
                $slide->save();
            }
        }
    }
}

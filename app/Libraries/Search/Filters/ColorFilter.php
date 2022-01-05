<?php

namespace App\Libraries\Search\Filters;

use App\Helpers\ColorHelpers;

class ColorFilter
{
    public function generate()
    {
        $base = [
            'title' => 'Color',
            'type' => 'color',
            'label' => 'Colorless',
            'active' => false,
            'enabled' => false,
        ];

        if (request()->filled('color')) {
            $base['href'] = route('collection', request()->except(['page', 'color', 'angle']));
            $base['label'] = $this->generateLabel();
            $base['active'] = true;
            $base['enabled'] = true;
        }

        return $base;
    }

    private function generateLabel()
    {
        $color = explode('-', request()->get('color'));
        $color[0] = $color[0] / 360;
        $color[1] = $color[1] / 100;
        $color[2] = $color[2] / 100;

        return 'Color: #' . ColorHelpers::hslToHex($color);
    }
}

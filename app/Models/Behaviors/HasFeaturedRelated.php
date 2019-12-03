<?php

namespace App\Models\Behaviors;

use Illuminate\Support\Str;

trait HasFeaturedRelated
{
    protected $selectedFeaturedRelated;

    /**
     * Select a random element from the relationships below and return one per request.
     *
     * For historical reasons, there's some inconsistency in relationship names,
     * so we attempt multiple variations and check if the method is defined.
     */
    public function getFeaturedRelatedAttribute()
    {
        if ($this->selectedFeaturedRelated) {
            return $this->selectedFeaturedRelated;
        }

        $types = collect([
            'sidebarArticle',
            'sidebarEvent',
            'sidebarExhibitions',
            'sidebarExperiences',
            'articles',
            'events',
            'exhibitions',
            'videos',
        ])->shuffle();

        foreach ($types as $type) {
            if (!method_exists($this, $type)) {
                continue;
            }

            if ($item = $this->$type()->first()) {
                switch ($type) {
                    case 'articles':
                        // passthrough
                    case 'sidebarArticle':
                        $type = 'article';
                        break;
                    case 'events':
                        // passthrough
                    case 'sidebarEvent':
                        $type = 'event';
                        break;
                    case 'exhibitions':
                        // passthrough
                    case 'sidebarExhibitions':
                        $item = $this->apiModels('sidebarExhibitions', 'Exhibition')->first();
                        $type = 'exhibition';
                        break;
                    case 'sidebarExperiences':
                        $type = 'experience';
                        break;
                    case 'videos':
                        $type = 'medias';
                        break;
                }

                return $this->selectedFeaturedRelated = [
                    'type' => Str::singular($type),
                    'items' => [$item],
                ];
            }
        }
    }

}

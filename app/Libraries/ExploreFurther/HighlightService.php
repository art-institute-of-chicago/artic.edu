<?php

namespace App\Libraries\ExploreFurther;

class HighlightService extends BaseService
{
    public function tags()
    {
        $tags = collect([]);

        // Build Classification Tags
        if ($this->resource->id) {
            foreach ($this->aggregations()->classifications->buckets as $index => $item) {
                if ($index == self::MAX_TAGS) {
                    break;
                }

                $tags = $tags->merge(
                    [$item->key => ucfirst($item->key)]
                );
            }
        }

        return [
            'classification' => $tags,
            'all' => collect([true => 'All Tags'])
        ];
    }
}

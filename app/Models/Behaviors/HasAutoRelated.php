<?php

namespace App\Models\Behaviors;

use App\Models\Vendor\Block;
use Illuminate\Support\Str;

trait HasAutoRelated
{
    public function related($id)
    {
        $modelName = Str::plural(Str::lower(class_basename(__CLASS__)));

        $blockableTypes = [
            'highlights',
            'educatorResources',
            'articles',
            'videos',
            'researchGuides',
            'genericPages',
            'events',
            'exhibitions',
        ];

        $relatedBlockItems = Block::whereIn('blockable_type', $blockableTypes)
            ->where('content', 'LIKE', '%"browsers"%')
            ->where('content', 'LIKE', '%' . $modelName . '%')
            ->where('content', 'LIKE', '%' . $id . '%')
            ->get();

        $relatedItems = [];
        foreach ($relatedBlockItems as $relatedBlockItem) {
            $relatedItems[] = $relatedBlockItem->blockable;
        }

        return $relatedItems;
    }
}

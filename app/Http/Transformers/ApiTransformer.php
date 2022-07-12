<?php

namespace App\Http\Transformers;

use Aic\Hub\Foundation\AbstractTransformer;

class ApiTransformer extends AbstractTransformer
{
    public $excludeIdsAndTitle = false;
    public $excludeDates = false;

    /**
     * Turn this item object into a generic array.
     *
     * @param  Illuminate\Database\Eloquent\Model  $item
     * @return array
     */
    public function transform($item)
    {
        $data = array_merge(
            $this->transformIdsAndTitle($item),
            $this->transformFields($item),
            $this->transformDates($item)
        );

        // Filters fields, etc.
        $data = parent::transform($data);

        return $data;
    }

    protected function transformFields($item)
    {
        return $item->transform();
    }


    protected function transformIdsAndTitle($item)
    {
        if ($this->excludeIdsAndTitle) {
            return [];
        }

        return [
            'id' => $item->getAttributeValue($item->getKeyName()),
        ];
    }

    protected function transformDates($item)
    {
        if ($this->excludeDates) {
            return [];
        }

        $dates = [];

        if ($item->updated_at) {
            $dates['updated_at'] = $item->updated_at->toIso8601String();
        }

        if ($item->created_at) {
            $dates['created_at'] = $item->created_at->toIso8601String();
        } else {
            $dates['created_at'] = null;
        }

        return $dates;
    }
}

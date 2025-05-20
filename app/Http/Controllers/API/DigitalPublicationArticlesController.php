<?php

namespace App\Http\Controllers\API;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class DigitalPublicationArticlesController extends BaseController
{
    protected $model = \App\Models\DigitalPublicationArticle::class;
    protected $transformer = \App\Http\Transformers\ApiTransformer::class;

    protected function getBaseQuery()
    {
        return parent::getBaseQuery()->whereExists(function (Builder $query) {
            $query->select(DB::raw(1))
                ->from('digital_publications')
                ->whereColumn('digital_publications.id', 'digital_publication_articles.id')
                ->where('digital_publications.is_unlisted', false);
        });
    }
}

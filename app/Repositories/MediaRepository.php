<?php

namespace App\Repositories;

use A17\Twill\Repositories\MediaRepository as BaseMediaRepository;

class MediaRepository extends BaseMediaRepository
{
    public function filter($query, array $scopes = [])
    {
        foreach (['withTag', 'withoutTag'] as $column) {
            if (isset($scopes[$column])) {
                $query->$column($scopes[$column]);
                unset($scopes[$column]);
            }
        }
        return parent::filter($query, $scopes);
    }
}

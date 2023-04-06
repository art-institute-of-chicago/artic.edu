<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use App\Models\Author;

class AuthorRepository extends ModuleRepository
{
    use HandleSlugs;
    use HandleMedias;
    use HandleRevisions;

    public function __construct(Author $model)
    {
        $this->model = $model;
    }
}

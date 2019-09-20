<?php

namespace App\Models\Behaviors;

use App\Models\Vendor\Block;
use A17\Twill\Models\Behaviors\HasBlocks as BaseHasBlocks;

trait HasBlocks
{

    use BaseHasBlocks {
        BaseHasBlocks::blocks as parentBlocks;
    }

    public function blocks()
    {
        return $this->morphMany(Block::class, 'blockable')->orderBy('blocks.position', 'asc');
    }

}

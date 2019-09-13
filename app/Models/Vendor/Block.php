<?php

namespace App\Models\Vendor;

use App\Models\Behaviors\LintsAttributes;
use App\Models\Behaviors\HasMedias;
use A17\Twill\Models\Block as BaseModel;
use A17\Twill\Models\Behaviors\HasMedias as BaseHasMedias;

class Block extends BaseModel
{
    use LintsAttributes, HasMedias;
}

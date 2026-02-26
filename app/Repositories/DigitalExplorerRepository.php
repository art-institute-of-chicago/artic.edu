<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use App\Models\DigitalExplorer;

class DigitalExplorerRepository extends ModuleRepository
{
    use HandleSlugs;
    use HandleMedias;
    use HandleBlocks;
    use HandleFiles;

    public function __construct(DigitalExplorer $model)
    {
        $this->model = $model;
    }

    protected $blockEditors = [
      'model_blocks',
      'annotation_blocks',
      'lighting_blocks',
    ];


    /**
     * Map custom block editor names to the standard 'blocks' key
     * so Twill's HandleBlocks can process them properly
     */
    public function prepareFieldsBeforeSave($object, $fields): array
    {
        $fields = parent::prepareFieldsBeforeSave($object, $fields);

        // Merge all custom block editors into the main 'blocks' array
        $allBlocks = [];

        if (isset($fields['model_blocks'])) {
            $allBlocks = array_merge($allBlocks, $fields['model_blocks']);
        }

        if (isset($fields['annotation_blocks'])) {
            $allBlocks = array_merge($allBlocks, $fields['annotation_blocks']);
        }

        if (isset($fields['lighting_blocks'])) {
            $allBlocks = array_merge($allBlocks, $fields['lighting_blocks']);
        }

        // Set the combined blocks
        if (!empty($allBlocks)) {
            $fields['blocks'] = $allBlocks;
        }

        return $fields;
    }
}

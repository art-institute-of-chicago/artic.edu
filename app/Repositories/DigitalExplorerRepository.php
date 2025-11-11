<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleRepeaters;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use App\Models\DigitalExplorer;

class DigitalExplorerRepository extends ModuleRepository
{
    use HandleSlugs;
    use HandleMedias;
    use HandleRepeaters;
    use HandleFiles;
    use HandleBlocks;

    public function __construct(DigitalExplorer $model)
    {
        $this->model = $model;

        $this->repeaters = [
            'digital_explorer_annotations',
            'digital_explorer_lights',
            'digital_explorer_models'
        ];
    }

    protected function getRepeaterRows($object, $fields, $repeater): array
    {
        $relationName = $this->getRepeaterRelationName($repeater);

        return $object->$relationName->map(function ($item) {
            if (method_exists($item, 'toRepeaterArray')) {
                return $item->toRepeaterArray();
            }
            return $item->toArray();
        })->toArray();
    }

    protected function getRepeaterRelationName(string $repeater): string
    {
        return lcfirst(str_replace('_', '', ucwords($repeater, '_')));
    }

    public function afterSave($object, $fields): void
    {
        \Log::info('DigitalExplorer afterSave START');

        parent::afterSave($object, $fields);

        if (isset($fields['repeaters']['digital_explorer_annotations'])) {
            $this->saveAnnotationBlocks($object, $fields['repeaters']['digital_explorer_annotations']);
        }
    }

    protected function saveAnnotationBlocks($object, array $annotationsData): void
    {
        $annotationRepo = app(DigitalExplorerAnnotationRepository::class);

        $savedAnnotations = $object->digitalExplorerAnnotations()->get();

        foreach ($annotationsData as $annotationData) {
            // Match by the position FIELD value (string), not array index
            $position = $annotationData['position'] ?? null;

            if ($position !== null) {
                // Position is stored as integer in DB but comes as string from form
                $annotation = $savedAnnotations->where('position', (int)$position)->first();

                if ($annotation && isset($annotationData['blocks']) && !empty($annotationData['blocks'])) {
                    \Log::info('Calling afterSaveHandleBlocks', [
                        'annotation_id' => $annotation->id,
                        'position' => $position,
                        'blocks_count' => count($annotationData['blocks'])
                    ]);

                    $annotationRepo->afterSaveHandleBlocks($annotation, ['blocks' => $annotationData['blocks']]);
                } else {
                    \Log::info('No blocks to save or annotation not found', [
                        'position' => $position,
                        'found' => !!$annotation,
                        'has_blocks' => isset($annotationData['blocks']),
                        'blocks_empty' => empty($annotationData['blocks'] ?? [])
                    ]);
                }
            }
        }
    }
}
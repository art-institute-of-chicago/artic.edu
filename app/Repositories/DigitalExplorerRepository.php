<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
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

    public function afterSave(TwillModelContract $object, array $fields): void
    {
        parent::afterSave($object, $fields);

        \Log::info('DigitalExplorerRepository afterSave', [
            'has_jsonOutput' => !empty($fields['jsonOutput']),
            'jsonOutput_preview' => substr($fields['jsonOutput'] ?? '', 0, 100),
        ]);

        if (!empty($fields['jsonOutput'])) {
            $data = json_decode($fields['jsonOutput'], true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
                $this->processJsonBlocksAfterSave($object, $data);
                
                if (isset($data['settings']) && is_array($data['settings'])) {
                    $this->processJsonSettingsAfterSave($object, $data['settings']);
                }
            } else {
                \Log::error('DigitalExplorerRepository afterSave JSON Decode Failed', [
                    'error' => json_last_error_msg(),
                ]);
            }
        }
    }

    protected function processJsonSettingsAfterSave($object, $settingsData)
    {
        $settings = $object->settings ?? collect();
        
        $stringify = function($val) {
            if (is_array($val)) return '[' . implode(', ', $val) . ']';
            return (string)$val;
        };

        if (isset($settingsData['enableCustomBounds'])) {
            $settings->put('enableCustomBounds', $settingsData['enableCustomBounds'] ? '1' : '0');
        }
        
        if (isset($settingsData['deactivateForcefield'])) {
            $settings->put('deactivateForcefield', $settingsData['deactivateForcefield'] ? '1' : '0');
        }

        if (isset($settingsData['customBounds'])) {
            $settings->put('customBounds', $stringify($settingsData['customBounds']));
        }

        if (isset($settingsData['customBoundsOffset'])) {
            $settings->put('customBoundsOffset', $stringify($settingsData['customBoundsOffset']));
        }

        if (isset($settingsData['zoomLimits'])) {
            $settings->put('zoomLimits', $stringify($settingsData['zoomLimits']));
        }

        $object->settings = $settings;
        $object->save();
    }

    protected function processJsonBlocksAfterSave($object, $data)
    {
        $blocks = $object->blocks()->get()->keyBy('id');
        $maxPosition = $blocks->whereNull('parent_id')->max('position') ?? 0;

        $stringify = function($val) {
            if (is_array($val)) return '[' . implode(', ', $val) . ']';
            return (string)$val;
        };

        foreach ($data['models'] ?? [] as $modelData) {
            $modelId = $modelData['id'] ?? null;
            if (!$modelId) continue;

            if ($blocks->has($modelId)) {
                $block = $blocks->get($modelId);
                $content = $block->content ?? [];

                \Log::info('processJsonBlocksAfterSave model', [
                    'modelId' => $modelId,
                    'oldContent' => $content,
                    'incomingContent' => $modelData['content'] ?? null,
                ]);

                if (isset($modelData['content'])) {
                    if (isset($modelData['content']['coordinate'])) $content['coordinate'] = $stringify($modelData['content']['coordinate']);
                    if (isset($modelData['content']['rotation'])) $content['rotation'] = $stringify($modelData['content']['rotation']);
                    if (isset($modelData['content']['scale'])) $content['scale'] = $stringify($modelData['content']['scale']);
                }

                \Log::info('processJsonBlocksAfterSave model updated content', [
                    'newContent' => $content,
                ]);

                $block->content = $content;
                $block->save();
            } else {
                \Log::info('processJsonBlocksAfterSave model block NOT FOUND', [
                    'modelId' => $modelId,
                    'availableBlocks' => $blocks->keys()->toArray()
                ]);
            }

            $childPosition = 1;
            foreach ($modelData['children'] ?? [] as $childData) {
                $childId = $childData['id'] ?? null;
                if (!$childId) continue;

                $childContent = [];
                if (isset($childData['content'])) {
                    if (isset($childData['content']['coordinate'])) $childContent['coordinate'] = $stringify($childData['content']['coordinate']);
                    if (isset($childData['content']['rotation'])) $childContent['rotation'] = $stringify($childData['content']['rotation']);
                    if (isset($childData['content']['scale'])) $childContent['scale'] = $stringify($childData['content']['scale']);
                    if (isset($childData['content']['labelText'])) $childContent['label'] = $stringify($childData['content']['labelText']);
                    if (isset($childData['content']['annotationZoom'])) $childContent['annotationZoom'] = $stringify($childData['content']['annotationZoom']);
                }

                if (is_string($childId) && str_starts_with($childId, 'annotation-')) {
                    \App\Models\Vendor\Block::create([
                        'blockable_id' => $object->id,
                        'blockable_type' => $object->getMorphClass(),
                        'parent_id' => $modelId,
                        'type' => 'explorer_annotation',
                        'editor_name' => 'model_blocks',
                        'child_key' => 'model_instance_blocks',
                        'position' => $childPosition,
                        'content' => $childContent,
                    ]);
                } elseif ($blocks->has($childId)) {
                    $childBlock = $blocks->get($childId);
                    $existingContent = $childBlock->content ?? [];
                    $childBlock->content = array_merge($existingContent, $childContent);
                    $childBlock->parent_id = $modelId;
                    $childBlock->child_key = 'model_instance_blocks';
                    $childBlock->editor_name = 'model_blocks';
                    $childBlock->position = $childPosition;
                    $childBlock->save();
                }
                $childPosition++;
            }
        }

        foreach ($data['annotations'] ?? [] as $annotationData) {
            $annotationId = $annotationData['id'] ?? null;
            if (!$annotationId) continue;

            $childContent = [];
            if (isset($annotationData['content'])) {
                if (isset($annotationData['content']['coordinate'])) $childContent['coordinate'] = $stringify($annotationData['content']['coordinate']);
                if (isset($annotationData['content']['rotation'])) $childContent['rotation'] = $stringify($annotationData['content']['rotation']);
                if (isset($annotationData['content']['scale'])) $childContent['scale'] = $stringify($annotationData['content']['scale']);
                if (isset($annotationData['content']['labelText'])) $childContent['label'] = $stringify($annotationData['content']['labelText']);
                if (isset($annotationData['content']['annotationZoom'])) $childContent['annotationZoom'] = $stringify($annotationData['content']['annotationZoom']);
            }

            if (is_string($annotationId) && str_starts_with($annotationId, 'annotation-')) {
                $maxPosition++;
                \App\Models\Vendor\Block::create([
                    'blockable_id' => $object->id,
                    'blockable_type' => $object->getMorphClass(),
                    'parent_id' => null,
                    'type' => 'explorer_annotation',
                    'editor_name' => 'annotation_blocks',
                    'position' => $maxPosition,
                    'content' => $childContent,
                ]);
            } elseif ($blocks->has($annotationId)) {
                $block = $blocks->get($annotationId);
                $existingContent = $block->content ?? [];
                $block->content = array_merge($existingContent, $childContent);
                $block->parent_id = null;
                $block->child_key = null;
                $block->editor_name = 'annotation_blocks';
                $block->save();
            }
        }

        // --- Lights ---
        $lightTypeMap = [
            'point' => 'pointLight',
            'directional' => 'directionalLight',
            'spot' => 'spotLight',
            'ambient' => 'ambient',
        ];

        foreach ($data['lights'] ?? [] as $lightData) {
            $lightId = $lightData['id'] ?? null;
            if (!$lightId) continue;

            $lightContent = [];
            if (isset($lightData['content'])) {
                $lc = $lightData['content'];
                if (isset($lc['lightType'])) {
                    $lightContent['lightType'] = $lightTypeMap[$lc['lightType']] ?? $lc['lightType'];
                }
                if (isset($lc['position'])) $lightContent['coordinate'] = $stringify($lc['position']);
                if (isset($lc['intensity'])) $lightContent['intensity'] = $stringify($lc['intensity']);
                if (isset($lc['color'])) $lightContent['color'] = $lc['color'];
                if (isset($lc['castShadow'])) $lightContent['castShadow'] = $lc['castShadow'] ? '1' : '0';
                if (isset($lc['angle'])) $lightContent['angle'] = $stringify($lc['angle']);
                if (isset($lc['penumbra'])) $lightContent['penumbra'] = $stringify($lc['penumbra']);
            }

            if (is_string($lightId) && str_starts_with($lightId, 'light-')) {
                $maxPosition++;
                \App\Models\Vendor\Block::create([
                    'blockable_id' => $object->id,
                    'blockable_type' => $object->getMorphClass(),
                    'parent_id' => null,
                    'type' => 'explorer_light',
                    'editor_name' => 'lighting_blocks',
                    'position' => $maxPosition,
                    'content' => $lightContent,
                ]);
            } elseif ($blocks->has($lightId)) {
                $block = $blocks->get($lightId);
                $existingContent = $block->content ?? [];
                $block->content = array_merge($existingContent, $lightContent);
                $block->save();
            }
        }
    }
}

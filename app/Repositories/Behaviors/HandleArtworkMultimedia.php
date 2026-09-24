<?php

namespace App\Repositories\Behaviors;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Models\RelatedItem;
use App\Models\Vendor\Block;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Manual curation for the artwork "Multimedia" browser.
 *
 * Unlike the other artwork browsers this one mixes regular modules (interactive
 * features and digital explorers) with blocks. Selecting a layered image viewer
 * block stores a live reference to the source block, so later edits to the
 * source propagate and deleting the source simply hides the section.
 */
trait HandleArtworkMultimedia
{
    public const ARTWORK_MULTIMEDIA_BROWSER = 'artwork_multimedia';

    public function afterSaveHandleArtworkMultimedia(TwillModelContract $object, array $fields): void
    {
        $items = $fields['browsers'][self::ARTWORK_MULTIMEDIA_BROWSER] ?? [];

        $position = 1;
        $rows = [];

        foreach ($items as $item) {
            $type = $item['endpointType'] ?? null;
            $id = $item['id'] ?? null;

            if (empty($type) || empty($id)) {
                continue;
            }

            $rows[] = [
                'subject_id' => $object->getKey(),
                'subject_type' => $object->getMorphClass(),
                'related_id' => $id,
                'related_type' => $type,
                'browser_name' => self::ARTWORK_MULTIMEDIA_BROWSER,
                'position' => $position,
            ];

            $position++;
        }

        RelatedItem::where([
            'browser_name' => self::ARTWORK_MULTIMEDIA_BROWSER,
            'subject_id' => $object->getKey(),
            'subject_type' => $object->getMorphClass(),
        ])->delete();

        foreach ($rows as $row) {
            RelatedItem::create($row);
        }
    }

    public function getFormFieldsHandleArtworkMultimedia(TwillModelContract $object, array $fields): array
    {
        $fields['browsers'][self::ARTWORK_MULTIMEDIA_BROWSER] = $object->relatedItems()
            ->where('browser_name', self::ARTWORK_MULTIMEDIA_BROWSER)
            ->orderBy('position')
            ->get()
            ->map(function (RelatedItem $related) {
                return $this->multimediaBrowserItem($related);
            })
            ->filter()
            ->values()
            ->toArray();

        return $fields;
    }

    /**
     * Build a single browser payload item from a stored related row.
     *
     * @param \A17\Twill\Models\RelatedItem $related The stored related row.
     *
     * @return array<string, mixed>|null
     */
    private function multimediaBrowserItem(RelatedItem $related): ?array
    {
        if ($related->related_type === 'blocks') {
            $block = Block::find($related->related_id);

            if (!$block) {
                return null;
            }

            $caption = trim(strip_tags($block->present()->input('caption_title') ?? ''));

            return [
                'id' => $block->getKey(),
                'name' => $caption !== '' ? $caption : 'Layered Image Viewer',
                'endpointType' => 'blocks',
                'position' => $related->position,
                'edit' => null,
            ];
        }

        $model = $this->resolveMorphModel($related->related_type, $related->related_id);

        if (!$model) {
            return null;
        }

        $item = [
            'id' => $model->getKey(),
            'name' => $model->titleInBrowser ?? $model->title,
            'endpointType' => $related->related_type,
            'position' => $related->position,
        ];

        if (!empty($model->adminEditUrl)) {
            $item['edit'] = $model->adminEditUrl;
        }

        if (classHasTrait($model, \App\Models\Behaviors\HasMedias::class)) {
            $item['thumbnail'] = $model->defaultCmsImage(['w' => 100, 'h' => 100]);
        }

        return $item;
    }

    /**
     * Resolve a morph alias (or class name) plus id to a model instance.
     *
     * @param string     $type The stored related type.
     * @param int|string $id   The stored related id.
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private function resolveMorphModel(string $type, $id): ?\Illuminate\Database\Eloquent\Model
    {
        $class = Relation::getMorphedModel($type) ?? $type;

        if (!class_exists($class)) {
            return null;
        }

        return $class::find($id);
    }
}

<?php

namespace App\Http\Controllers\Twill;

use App\Libraries\ArtworkSectionService;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\Vendor\Block;
use Illuminate\Http\JsonResponse;

class ArtworkController extends BaseApiController
{
    public function setUpController(): void
    {
        $this->enableAugmentedModel();
        $this->disablePublish();
        $this->enableShowImage();
        $this->setTitleColumnKey('fullTitle');
        $this->setSearchColumns(['title', 'artist_title', 'main_reference_number']);
        $this->setModuleName('artworks');
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = TableColumns::make();
        $columns->add(
            Text::make()
                ->title('Reference number')
                ->field('main_reference_number')
                ->optional()
        );
        $columns->add(
            Text::make()
                ->title('Artist')
                ->field('artist_display')
                ->optional()
        );
        return $columns;
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('artwork') ?? request('id'));
        $baseUrl = config('app.url') . '/artworks/' . $item->datahub_id . '/';

        return [
            'autoRelated' => $this->getAutoRelated($item),
            'featuredRelated' => $this->getFeatureRelated($item),
            'autoPublications' => ArtworkSectionService::autoPublications((int) $item->datahub_id),
            'autoExhibitions' => ArtworkSectionService::autoExhibitions((int) $item->datahub_id),
            'autoEducatorResources' => ArtworkSectionService::autoEducatorResources((int) $item->datahub_id),
            'editableTitle' => false,
            'baseUrl' => $baseUrl,
        ];
    }

    public function browser(): JsonResponse
    {
        // Allow to filter by IDS when listing artworks.
        return response()->json($this->getBrowserData(['id' => request('artwork_ids')]));
    }

    /**
     * Browser for the layered image viewer source blocks that can be snapshotted
     * into the artwork Multimedia section.
     */
    public function layeredImageViewerBlocksBrowser(): JsonResponse
    {
        $search = trim((string) request('search'));

        $blocks = Block::query()
            ->where('type', 'layered_image_viewer')
            ->whereNull('parent_id')
            ->where(function ($query) {
                $query->whereNull('blockable_type')
                    ->orWhere('blockable_type', '!=', 'App\Models\Artwork');
            })
            ->without('medias', 'children')
            ->with('blockable')
            ->orderBy('id')
            ->get();

        $items = $blocks->map(function (Block $block) {
            return [
                'id' => $block->getKey(),
                'name' => $this->multimediaBlockBrowserName($block),
                'endpointType' => 'blocks',
                'edit' => $this->multimediaBlockParentEditUrl($block),
            ];
        });

        if ($search !== '') {
            $needle = mb_strtolower($search);

            $items = $items->filter(function ($item) use ($needle) {
                return mb_strpos(mb_strtolower($item['name']), $needle) !== false;
            })->values();
        }

        return response()->json(['data' => $items->values()->all()]);
    }

    /**
     * Human readable name for a source layered image viewer block.
     */
    private function multimediaBlockBrowserName(Block $block): string
    {
        $parentTitle = $this->multimediaBlockParentTitle($block);
        $caption = trim(strip_tags($block->present()->input('caption_title') ?? ''));
        $label = $caption !== '' ? $caption : 'Layered Image Viewer';

        if (!empty($parentTitle)) {
            $label = $parentTitle . ' — ' . $label;
        }

        return $label . ' (#' . $block->getKey() . ')';
    }

    /**
     * Title of the block's owner, without triggering API-backed accessors.
     */
    private function multimediaBlockParentTitle(Block $block): ?string
    {
        $parent = $block->blockable;

        if (!$parent) {
            return null;
        }

        $title = $parent->titleInBrowser ?? $parent->getRawOriginal('title') ?? null;

        return is_string($title) ? $title : null;
    }

    /**
     * Admin edit URL for the block's owner, when it has one.
     */
    private function multimediaBlockParentEditUrl(Block $block): ?string
    {
        $parent = $block->blockable;

        if (!$parent) {
            return null;
        }

        // Building the URL can touch relations that are not resolvable (e.g. an
        // unpublished parent publication), which raises a warning. Swallow it so
        // a missing edit link never breaks the browser.
        set_error_handler(static function () {
            return true;
        });

        try {
            return $parent->adminEditUrl ?: null;
        } catch (\Throwable $e) {
            return null;
        } finally {
            restore_error_handler();
        }
    }
}
